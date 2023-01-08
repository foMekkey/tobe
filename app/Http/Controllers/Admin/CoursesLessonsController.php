<?php

namespace App\Http\Controllers\Admin;

use App\Courses;
use App\CoursesGroup;
//use App\CourseSection;
use App\CoursesLessons;
use App\CoursesUser;
use App\CourseTerms;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class CoursesLessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //$courseSectionId = CourseSection::all()->pluck('title', 'id');

        $courseTypes = CoursesLessons::lessonType();

        return view('backend.lessons.create', compact(/*'courseSectionId',*/'id', 'courseTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*$request->validate([

            'file' => 'required|max:2048',

        ]);*/

        $courses = new CoursesLessons();
        $courses->number_lession            = $request->number_lession;
        $courses->course_id                 = $request->course_id;
        //$courses->course_section_id         = $request->course_section_id;
        $courses->name                      = $request->name;
        $courses->content                   = ($request->type == 3 || $request->type == 4) ? $request->content : '';
        $courses->file                      = ($request->hasFile('file')) ? $request->file->store('lessons') : NULL;
        //        $courses->type                      = $request->file->getMimeType();
        $courses->sort                      = $request->sort;
        $courses->type                      = $request->type;
        $courses->period                    = $request->period;
        $courses->period_type                   = $request->period_type;
        $courses->save();

        return redirect('courses')->with(['success' =>  __('pages.success-add')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = CoursesLessons::find($id);

        return view('backend.lessons.show', compact('lesson'));
    }


    public function DatatableUsersCourses($id)
    {

        $users = CoursesUser::where('course_id', $id)->get();
        $courseGroup = CoursesGroup::whereCourseId($id)->get();
        $allUsersCollections = $users->merge($courseGroup);
        $courses = Courses::find($id);

        return \DataTables::of($users)

            ->editColumn('type', function ($query) {
                if ($query->roles)
                    return '<span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">' . $query->roles->role . '</span>';
                return '<span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">' . __('pages.no-permission-detected') . '</span>';
            })

            ->editColumn('user_name', function ($query) {
                return  $user = User::find($query->user_id)->user_name;
            })

            ->editColumn('group', function ($query) {
                return  $user = User::find($query->user_id)->user_name;
            })

            ->addColumn('options', function ($query)  use ($courses) {
                $user_id = $query->id;
                $course_id = $courses->id;
                return view('backend.courses.actionUsers', compact('course_id', 'user_id'));
            })
            ->rawColumns(['options', 'type'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $lesson_id)
    {
        $lesson = CoursesLessons::find($lesson_id);
        //$courseSectionId = CourseSection::all()->pluck('title', 'id');
        $courseTypes = CoursesLessons::lessonType();
        return view('backend.lessons.edit', compact(/*'courseSectionId',*/'course_id', 'courseTypes', 'lesson'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_id, $lesson_id)
    {

        $lesson = CoursesLessons::find($lesson_id);
        $lesson->number_lession            = $request->number_lession;
        $lesson->course_id                 = $course_id;
        //$lesson->course_section_id         = $request->course_section_id;
        $lesson->name                      = $request->name;
        $lesson->content                   = $request->content;
        $lesson->file                      = ($request->hasFile('file')) ? $request->file->store('lessons') : $lesson->file;
        $lesson->type                      = ($request->hasFile('file')) ? $request->file->getMimeType() : $lesson->mime;
        $lesson->sort                      = $request->sort;
        $lesson->type                      = $request->type;
        $lesson->period                    = $request->period;
        $lesson->period_type                    = $request->period_type;
        $lesson->update();

        return redirect('courses/show-all/' . $course_id)->with(['success' =>  __('pages.success-edit')]);
    }

    public function trams(Request $request, $id)
    {

        $courses =  CourseTerms::where('course_id', $id)->first();
        $courses->course_id                           = $id;
        $courses->rules_of_traversal                  = $request->rules_of_traversal;
        $courses->rules_of_achievement                = $request->rules_of_achievement;
        $courses->learning_methods                    = $request->learning_methods;
        $courses->collect_result                      = $request->collect_result;
        $courses->save();

        return redirect('courses')->with(['success' =>  __('pages.success-add')]);
    }
}