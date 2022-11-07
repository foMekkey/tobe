<?php

namespace App\Http\Controllers\Admin;

use App\Survey;
use App\SurveyQuestion;
use App\SurveyQuestionAnswer;
use App\CoursesUser;
use App\Groups;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\DataTables\SurveysDatatable;
use App\Http\Requests\SurveysRequest;
use Auth;

class SurveyController extends Controller
{
    /**
     * @param SurveysDatatable $surveysDatatable
     * @return mixed
     */
    public function index($courseId, SurveysDatatable $surveysDatatable)
    {
        return $surveysDatatable->with('course_id', $courseId)->render('backend.surveys.index', compact('courseId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($courseId)
    {
        return view('backend.surveys.create', compact('courseId'));
    }


    /**
     * @param SurveysRequest $surveysRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store($courseId, Request $request)
    {
        $this->validate($request, [
            'is_day_star' => 'required|in:0,1',
            'title' => 'required',
            'date' => 'required',
            'questions' => 'required'
        ]);
        
        $data = [
            'user_id' => Auth::user()->id,
            'course_id' => $courseId,
            'title' => $request->title,
            'is_day_star' => $request->is_day_star,
            'date' => Carbon::createFromFormat('m/d/Y', $request->date),
            'show_results_in_course' => isset($request->show_results_in_course) ? 1 : 0,
            'status' => isset($request->status) ? 1 : 0
        ];
        $survey = Survey::create($data);
        
        if ($survey) {
            $questions = [];
            $requestQuestions = $request->questions;
            foreach ($requestQuestions['question'] as $i => $question) {
                if (!empty($question) && !empty($requestQuestions['type'][$i]) && in_array($requestQuestions['type'][$i], [1, 2, 3]) && 
                   ($requestQuestions['type'][$i] == '1' || $request->is_day_star == '1' ||
                        ($requestQuestions['type'][$i] != '1' && !empty($requestQuestions['allowed_options'][$i])))) {
                    $questions[] = [
                        'survey_id' => $survey->id,
                        'question' => $question,
                        'type' => $requestQuestions['type'][$i],
                        'allowed_options' => ($requestQuestions['type'][$i] != '1' && $request->is_day_star == '0' ? $requestQuestions['allowed_options'][$i] : ''),
                        'is_required' => isset($requestQuestions['is_required'][$i]) ? 1 : 0
                    ];
                }
            }
            if (count($questions)) {
                SurveyQuestion::insert($questions);
                
                return redirect('surveys/' . $courseId)->with(['success' =>  __('pages.success-add')]);
            } else {
                $survey->delete();
                
                return redirect()->back()->with('error', __('pages.add-survey-error-questions'));
            }
        }
        
        return redirect()->back()->with('error', __('pages.add-survey-error'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($courseId, $id)
    {
        $survey = Survey::findOrFail($id);
        $questions = SurveyQuestion::where('survey_id', $id)->get();
        
        $readonly = '';
        $hasAnswer = SurveyQuestionAnswer::where('survey_id', $id)->first();
        if ($hasAnswer) {
            $readonly = 'readonly';
        }
        
        return view('backend.surveys.edit', compact('survey', 'questions', 'courseId', 'readonly'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $courseId, $id)
    {
        $this->validate($request, [
            'is_day_star' => 'required|in:0,1',
            'title' => 'required',
            'date' => 'required',
            'questions' => 'required'
        ]);
        
        $survey = Survey::findOrFail($id);
        $hasAnswer = SurveyQuestionAnswer::where('survey_id', $id)->first();
        if ($hasAnswer) {
            $survey->show_results_in_course = isset($request->show_results_in_course) ? 1 : 0;
            $survey->status = isset($request->status) ? 1 : 0;
            $survey->save();
            
            return redirect('surveys/' . $courseId)->with(['success' =>  __('pages.success-edit')]);
        }
        
        $data = [
            'title' => $request->title,
            'is_day_star' => $request->is_day_star,
            'date' => Carbon::createFromFormat('m/d/Y', $request->date),
            'show_results_in_course' => isset($request->show_results_in_course) ? 1 : 0,
            'status' => isset($request->status) ? 1 : 0
        ];
        
        $questions = [];
        $requestQuestions = $request->questions;
        foreach ($requestQuestions['question'] as $i => $question) {
            if (!empty($question) && !empty($requestQuestions['type'][$i]) && in_array($requestQuestions['type'][$i], [1, 2, 3]) && 
               ($requestQuestions['type'][$i] == '1' || $request->is_day_star == '1' ||
                    ($requestQuestions['type'][$i] != '1' && !empty($requestQuestions['allowed_options'][$i])))) {
                $questions[] = [
                    'survey_id' => $survey->id,
                    'question' => $question,
                    'type' => $requestQuestions['type'][$i],
                    'allowed_options' => ($requestQuestions['type'][$i] != '1' && $request->is_day_star == '0' ? $requestQuestions['allowed_options'][$i] : ''),
                    'is_required' => isset($requestQuestions['is_required'][$i]) ? 1 : 0
                ];
            }
        }
        if (count($questions)) {
            Survey::where('id', $id)->update($data);
            SurveyQuestion::where('survey_id', $survey->id)->delete();
            SurveyQuestion::insert($questions);

            return redirect('surveys/' . $courseId)->with(['success' =>  __('pages.success-edit')]);
        } else {
            return redirect()->back()->with('error', __('pages.add-survey-error-questions'));
        }
        
        return redirect()->back()->with('error', __('pages.edit-survey-error'));
    }
    
    public function results($courseId, $id)
    {
        $survey = Survey::findOrFail($id);
        
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
        
        return view('backend.surveys.results',compact('survey', 'questions', 'answersPerQuestions', 'courseId', 'courseUsers'));
    }
}
