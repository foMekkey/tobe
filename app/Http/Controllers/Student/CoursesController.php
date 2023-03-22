<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

use App\Courses;
//use App\CourseSection;
use App\CoursesLessons;
use App\CoursesUser;
use App\CourseTerms;
use App\CategoiresCourses;
use App\CourseUserLog;
use App\Survey;
use App\SurveyQuestion;
use App\SurveyQuestionAnswer;
use App\CourseReview;
use App\Subscription;
use App\Bank;
use App\E_Wallet;
use Session;
use Carbon\Carbon;

class CoursesController extends Controller
{
    public function index()
    {
        $coursesInProgress = CoursesUser::where(['user_id' => auth()->id(), 'status' => 0])->count();
        $coursesCompleted = CoursesUser::where(['user_id' => auth()->id(), 'status' => 1])->count();
        $coursesCompletedIds = CoursesUser::where(['user_id' => auth()->id(), 'status' => 1])->pluck('course_id')->toArray();
        $coursesCompletedDurations = Courses::whereIn('id', $coursesCompletedIds)->sum('duration');

        $courses  = CoursesUser::with('Courses')->where('user_id', auth()->id())->get();
        foreach ($courses as $course) {
            $course->lessons_count = CoursesLessons::where('course_id', $course->Courses->id)->count();
            $course->completed_lessons_count = CourseUserLog::where(['course_user_id' => $course->id, 'status' => 1])->count();
            $course->progress_percentage = $course->lessons_count ? round(($course->completed_lessons_count / $course->lessons_count) * 100, 0) : 0;
        }

        $groupsIds = \App\GroupMember::where('student_id', auth()->id())->pluck('group_id')->toArray();
        $coursesIds = \App\CoursesGroup::whereIn('group_id', $groupsIds)->pluck('course_id')->toArray();
        $groupCourses  = Courses::whereIn('id', $coursesIds)->get();
        foreach ($groupCourses as $course) {
            $course->lessons_count = CoursesLessons::where('course_id', $course->id)->count();
            //$course->completed_lessons_count = CourseUserLog::where(['course_user_id' => $course->id, 'status' => 1])->count();
            //$course->progress_percentage = $course->lessons_count ? round(($course->completed_lessons_count / $course->lessons_count) * 100, 0) : 0;
        }

        return view('students.courses.index', compact('courses', 'coursesInProgress', 'coursesCompleted', 'coursesCompletedDurations', 'groupCourses'));
    }

    /*public function show($id){
        $courseData = Courses::find($id);
        //$sections = CourseSection::where('course_id',$id)->get();
        $terms = CourseTerms::where('course_id',$id)->first();
        $coursesLessons = CoursesLessons::where('course_id',$id)->get(); //LessonInSameSection($id);
        $courses_count = CoursesLessons::where('course_id',$id)->count();
        return view('students.courses.showCourse',compact('coursesLessons','courses_count','courseData','terms')); //,'sections'
    }*/

    public function subscripe($id)
    {
        $course_id = $id;
        if (auth()->user()) {

            $user_id = auth()->user()->id;

            if (
                CoursesUser::where('course_id', $course_id)->where('user_id', $user_id)->exists() ||
                Subscription::where('user_id', $user_id)->where('status', 0)->where('course_id', $course_id)->exists()
            ) {
                return redirect()->back();
            }
            $banks = Bank::where('active', 1)->get();
            $e_wallets = E_Wallet::where('active', 1)->get();
            $course = Courses::find($id);
            return view('students.courses.payment', compact('course', 'banks', 'e_wallets'));
        } else {
            return redirect()->back();
        }
    }


    public function showLesson($id)
    {
        $courses_lesson = CoursesLessons::findOrFail($id);
        $courseUser = CoursesUser::where(['user_id' => auth()->id(), 'course_id' => $courses_lesson->course_id])->first();
        $courseUserLog = [];
        if ($courseUser) {
            $courseUserLog = CourseUserLog::where(['course_user_id' => $courseUser->id, 'course_lesson_id' => $id])->first();
        }

        return view('students.courses.lesson', compact('courses_lesson', 'courseUserLog'));
    }

    public function catalog($categoryId = '')
    {
        $where = ['hide_from_catalog' => 0, 'status' => 1];
        if ($categoryId) {
            $where['category_id'] = $categoryId;
        }
        $courses = Courses::where($where)->get();
        $categories = CategoiresCourses::all();
        $userCourses = CoursesUser::where('user_id', auth()->id())->pluck('course_id')->toArray();
        $userSubscriptions = Subscription::where('user_id', auth()->id())->where('status', 0)->pluck('course_id')->toArray();

        return view('students.courses.catalog', compact('courses', 'userCourses', 'userSubscriptions', 'categories', 'categoryId'));
    }

    public function show($id)
    {
        $courseData = Courses::find($id);
        $coursesLessons = CoursesLessons::where('course_id', $id)->orderBy('number_lession')->get();
        $courseUser = CoursesUser::where(['user_id' => auth()->id(), 'course_id' => $id])->first();
        $completedLessons = $courseSurveys = $courseCompletedSurveys = [];
        if ($courseUser) {
            $completedLessons = CourseUserLog::where(['course_user_id' => $courseUser->id, 'status' => 1])->pluck('course_lesson_id')->toArray();
            $courseSurveys = Survey::where('status', 1)->where('course_id', $id)->where('date', date('Y-m-d'))->get();
            $courseCompletedSurveys = Survey::where('status', 1)->where('show_results_in_course', 1)->where('course_id', $id)->where('date', '<', date('Y-m-d'))->get();
        }

        $icons = ['fa-file-text-o', 'fa-file-o', 'fa-play-circle-o', 'fa-question-circle-o'];

        /*return view('students.courses.show',compact('courseData', 'coursesLessons', 'courseUser', 'completedLessons', 'courseSurveys', 'courseCompletedSurveys', 'icons'));*/


        $course = Courses::where('id', $id)->first();
        if (!$course) {
            abort(404);
        }

        $latestCourses = Courses::where('id', '!=', $id)->where('status', 0)->orderBy('id', 'desc')->limit(3)->get();
        $categories = CategoiresCourses::whereHas('courses')->orderBy('name', 'asc')->get();

        $reviewsCount = $reviewsAvg = 0;
        $reviewsGrouped = [];
        $reviews = CourseReview::select('rate', \DB::raw('count(*) as cnt'))->where('course_id', $id)->groupBy('rate')->get();
        if (count($reviews)) {
            $reviewsCount = $reviews->sum('cnt');
            $reviewsAvg = $reviews->sum('rate') / $reviewsCount;
            $reviewsGrouped = $reviews->pluck('cnt', 'rate')->toArray();
        }

        return view('students.courses.show', compact(
            'course',
            'latestCourses',
            'categories',
            'reviewsCount',
            'reviewsAvg',
            'reviewsGrouped',
            'coursesLessons',
            'courseUser',
            'completedLessons',
            'courseSurveys',
            'courseCompletedSurveys',
            'icons',
            'courseData'
        ));
    }

    public function joinCourse(Request $request)
    {
        if (!empty($request->id)) {
            CoursesUser::create([
                'user_id' => auth()->id(),
                'course_id' => $request->id
            ]);

            Session::flash('success', 'تم الإشتراك بنجاح');

            return Response::json(['success' => true], '200');
        } else {
            return Response::json(['success' => false], '200');
        }
    }

    public function finishLesson(Request $request)
    {
        if (!empty($request->id) && !empty($request->course_id)) {
            $courseUser = CoursesUser::where(['user_id' => auth()->id(), 'course_id' => $request->course_id])->first();
            if ($courseUser) {
                $exists = CourseUserLog::where(['course_user_id' => $courseUser->id, 'course_lesson_id' => $request->id])->first();
                if ($exists) {
                    $exists->status = 1;
                    $exists->save();
                } else {
                    CourseUserLog::create([
                        'course_user_id' => $courseUser->id,
                        'course_lesson_id' => $request->id,
                        'status' => 1
                    ]);
                }

                // add points
                $settings = \App\Setting::whereIn('name', ['check_points_group', 'complete_unit'])->pluck('value', 'name')->toArray();
                if ($settings['check_points_group'] == 'on' && $settings['complete_unit']) {
                    if (!auth()->user()->points) {
                        auth()->user()->points = $settings['complete_unit'];
                        auth()->user()->save();
                    } else {
                        auth()->user()->increment('points', $settings['complete_unit']);
                    }
                }

                $lessonsCount = CoursesLessons::where('course_id', $request->course_id)->count();
                $completedLessonsCount = CourseUserLog::where(['course_user_id' => $courseUser->id, 'course_lesson_id' => $request->id, 'status' => 1])->count();
                if ($lessonsCount == $completedLessonsCount) {
                    $courseUser->status = 1;
                    $courseUser->save();

                    // add points
                    $settings = \App\Setting::whereIn('name', ['check_points_group', 'complete_course'])->pluck('value', 'name')->toArray();
                    if ($settings['check_points_group'] == 'on' && $settings['complete_course']) {
                        if (!auth()->user()->points) {
                            auth()->user()->points = $settings['complete_course'];
                            auth()->user()->save();
                        } else {
                            auth()->user()->increment('points', $settings['complete_course']);
                        }
                    }
                }

                return Response::json(['success' => true], '200');
            } else {
                return Response::json(['success' => false], '200');
            }
        } else {
            return Response::json(['success' => false], '200');
        }
    }

    public function showSurvey($id)
    {
        $survey = Survey::where('id', $id)->where('status', 1)->where('date', date('Y-m-d'))->firstOrFail();
        $courseUser = CoursesUser::where('user_id', auth()->id())->where('course_id', $survey->course_id)->firstOrFail();
        $surveyAnswerExists = SurveyQuestionAnswer::where('survey_id', $id)->where('user_id', auth()->id())->first();

        $courseUsers = [];
        if ($survey->is_day_star) {
            $courseUsers = CoursesUser::where('course_id', $survey->course_id)->where('user_id', '!=', auth()->id())->with('user')->get();
        }

        $questions = SurveyQuestion::where('survey_id', $id)->get();

        return view('students.courses.show-survey', compact('survey', 'surveyAnswerExists', 'questions', 'courseUsers'));
    }

    public function answerSurvey($id, Request $request)
    {
        $survey = Survey::where('id', $id)->where('status', 1)->where('date', date('Y-m-d'))->firstOrFail();
        $courseUser = CoursesUser::where('user_id', auth()->id())->where('course_id', $survey->course_id)->firstOrFail();
        $surveyAnswerExists = SurveyQuestionAnswer::where('survey_id', $id)->where('user_id', auth()->id())->first();
        if ($surveyAnswerExists) {
            return redirect()->back()->with('error', __('pages.survey-error-already-answered'));
        }

        $answers = [];
        $questions = SurveyQuestion::where('survey_id', $id);
        $currentDateTime = Carbon::now();
        $requiredQuestions = $questions->where('is_required', '1')->pluck('id')->toArray();
        foreach ($request->questions as $question => $answer) {
            if (in_array($question, $requiredQuestions) && empty($answer)) {
                return redirect()->back()->with('error', __('pages.survey_validation_msg'));
            }
            $answers[] = [
                'survey_id' => $id,
                'survey_question_id' => $question,
                'user_id' => auth()->id(),
                'answer' => $answer,
                'datetime' => $currentDateTime
            ];
        }

        if (count($answers)) {
            SurveyQuestionAnswer::insert($answers);

            return redirect(route('showCourseDetailsStudent', $survey->course_id))->with(['success' => __('pages.success-survey-answers')]);
        }

        return redirect()->back()->with('error', __('pages.survey_validation_msg_at_least_one'));
    }

    public function showSurveyResults($id)
    {
        $survey = Survey::where('id', $id)->where('status', 1)->where('show_results_in_course', 1)->where('date', '<', date('Y-m-d'))->firstOrFail();
        $questions = SurveyQuestion::where('survey_id', $id)->get();

        $answersPerQuestions = [];
        $answers = SurveyQuestionAnswer::select('survey_question_id', 'answer', \DB::raw('count(*) as cnt'))
            ->where('survey_id', $id)
            ->groupBy('survey_question_id')->groupBy('answer')
            ->orderBy('survey_question_id', 'asc')
            ->orderBy('cnt', 'desc')
            ->get();
        foreach ($answers as $answer) {
            $answersPerQuestions[$answer->survey_question_id][$answer->answer] = $answer->cnt;
        }

        $courseUsers = [];
        if ($survey->is_day_star) {
            $courseUsersQuery = CoursesUser::where('course_id', $survey->course_id)->with('user')->get();
            foreach ($courseUsersQuery as $courseUser) {
                $courseUsers[$courseUser->user_id] = $courseUser->user->user_name ?? '';
            }
        }

        return view('students.courses.results', compact('survey', 'questions', 'answersPerQuestions', 'courseUsers'));
    }
}