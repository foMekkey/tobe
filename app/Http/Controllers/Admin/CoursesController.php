<?php

namespace App\Http\Controllers\Admin;
use App\CategoiresCourses;
use App\Courses;
use App\CoursesGroup;
use App\CoursesUser;
use App\CourseTerms;
use App\CoursesLessons;
use App\DataTables\CoursesDatatable;
use App\GroupMember;
use App\Groups;
use App\Http\Requests\CoursesRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class CoursesController extends Controller
{

    /**
     * @param CoursesDatatable $coursesDatatable
     * @return mixed
     */
    public function index(CoursesDatatable $coursesDatatable)
    {
        return $coursesDatatable->render('backend.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trainers = User::where('type', 2)->pluck('user_name', 'id')->toArray();
        $categories = CategoiresCourses::all()->pluck('name', 'id');
        return view('backend.courses.create',compact('categories', 'trainers'));
    }


    /**
     * @param CoursesRequest $coursesRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CoursesRequest $coursesRequest)
    {

        $full_date = explode("-", $coursesRequest->dateRange);

        $dateFrom = $full_date[0];
        $dateTo = $full_date[1];

        $timestamp_from = Carbon::createFromFormat('m/d/Y', trim($dateFrom));
        $timestamp_to = Carbon::createFromFormat('m/d/Y',trim($dateTo));

        if(isset($coursesRequest->status) ||  $coursesRequest->status != null)
        {
            $stauts = $coursesRequest->status;
        }else{
            $stauts = 0;
        }


        if(isset($coursesRequest->image) ||  $coursesRequest->image != null)
        {
            $image = $coursesRequest->image->store('courses');
        }else{
            $image = 'courses/download.jpeg';
        }

        if(isset($coursesRequest->hide_from_catalog) ||  $coursesRequest->hide_from_catalog != null)
        {
            $hide_from_catalog = $coursesRequest->hide_from_catalog;
        }else{
            $hide_from_catalog = 0;
        }

        $courses = new Courses();
        $courses->user_id           = $coursesRequest->user_id;
        $courses->category_id       = $coursesRequest->category_id;
        $courses->name              = $coursesRequest->name;
        $courses->lang              = $coursesRequest->lang ?? 'en';
        $courses->level             = $coursesRequest->level;
        $courses->desc              = $coursesRequest->desc;
        $courses->content           = $coursesRequest->content;
        $courses->status            = $stauts;
        $courses->hide_from_catalog = $hide_from_catalog;
        $courses->tags              = $coursesRequest->tags;
        $courses->price             = $coursesRequest->price;
        $courses->start_date        = $timestamp_from;
        $courses->end_date          = $timestamp_to;
        $courses->duration          = $coursesRequest->duration;
        $courses->image             = $image;
        $courses->complete_rules    = $coursesRequest->complete_rules;
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
        $courseData = Courses::find($id);
        //$sections = CourseSection::where('course_id',$id)->get();
        $terms = CourseTerms::where('course_id',$id)->first();
        $coursesLessons = CoursesLessons::where('course_id',$id)->orderBy('number_lession')->get(); //LessonInSameSection($id);
        //print_r($coursesLessons);exit;
        $courses_count = CoursesLessons::where('course_id',$id)->count();
        return view('backend.courses.showCourse',compact('coursesLessons','courses_count','courseData'/*,'sections'*/,'terms'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $courses = Courses::find($id);

        $enddate =   Carbon::parse($courses->end_date)->format('m/d/Y');

        $startdate =   Carbon::parse($courses->start_date)->format('m/d/Y');

        $coursesCategories = CategoiresCourses::pluck('name', 'id')->toArray();
        $trainers = User::where('type', 2)->pluck('user_name', 'id')->toArray();
        return  view('backend.courses.edit',compact('courses','coursesCategories', 'trainers','startdate','enddate'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'name'=>'required',
            'category_id'=>'required',
            'user_id'=>'required',
            'level'=>'required',
            'duration'=>'required',
        ]);


        if(isset($request->status) ||  $request->status != null)
        {
            $stauts = $request->status;
        }else{
            $stauts = 0;
        }

        if(isset($request->hide_from_catalog) ||  $request->hide_from_catalog != null)
        {
            $hide_from_catalog = $request->hide_from_catalog;
        }else{
            $hide_from_catalog = 0;
        }


        $full_date = explode("-", $request->dateRange);
        $dateFrom = $full_date[0];
        $dateTo = $full_date[1];
        $timestamp_from = Carbon::createFromFormat('m/d/Y', trim($dateFrom))->toDateTimeString();
        $timestamp_to = Carbon::createFromFormat('m/d/Y', trim($dateTo))->toDateTimeString();

        $courses = Courses::find($id);
        $courses->user_id            = $request->user_id;
        $courses->category_id        = $request->category_id;
        $courses->lang               = $request->lang ?? 'en';
        $courses->name               = $request->name;
        $courses->level              = $request->level;
        $courses->desc               = $request->desc;
        $courses->content            = $request->content;
        $courses->status             = $stauts;
        $courses->hide_from_catalog  = $hide_from_catalog;
        $courses->tags               = $request->tags;
        $courses->price              = $request->price;
        $courses->start_date         = $timestamp_from;
        $courses->end_date           = $timestamp_to;
        $courses->duration           = $request->duration;
        $courses->image              = ($request->hasFile('image')) ? $request->image->store('courses') : $courses->image;
        $courses->complete_rules     = $request->complete_rules;
        $courses->update();

        return redirect('courses')->with(['success' =>  __('pages.success-edit')]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $courses = Courses::find($id);

        $check = $courses->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));

        }
    }


    public function DatatableUsersCourses($id)
    {

        $users = User::get();
        $courses = Courses::find($id);

        return \DataTables::of($users)

            ->editColumn('type',function($query){
                if($query->type == 1)
                {
                    return '<span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">مسئول</span>';
                }elseif ($query->type == 2){
                    return '<td><span class="kt-badge kt-badge--danger kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-danger">مدرب</span></td>';
                }else{
                    return '<span class="kt-badge kt-badge--primary kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-primary">طالب</span>';
                }
            })

            ->addColumn('options', function($query)  use ($courses){
                $user_id = $query->id;
                $course_id = $courses->id;
                return view('backend.courses.actionUsers', compact('course_id','user_id'));
            })


            ->rawColumns(['options','type'])
            ->make(true);
    }


    public function DatatableCoursesGroups($id)
    {

        $groups = Groups::get();
        $courses = Courses::find($id);

        return \DataTables::of($groups)

            ->addColumn('options', function($query)  use ($courses){
                $group_id = $query->id;
                $courses_id = $courses->id;
                return view('backend.courses.actionGroups', compact('group_id','courses_id'));
            })

            ->rawColumns(['options'])
            ->make(true);
    }




    public function destroyUserFromList($user_id,$course_id)
    {

        $user = CoursesUser::where('user_id',$user_id)->where('course_id',$course_id)->first();

        $check = $user->delete();

        return redirect()->back()->with('error',__('pages.success-delete'));
    }


    public function addUserFromList($user_id,$course_id)
    {

        $course = new CoursesUser();
        $course->course_id = $course_id;
        $course->user_id = $user_id;
        $course->save();

        return redirect()->back()->with('error',__('pages.success-join'));
    }




    public function destroyGroupFromList($group_id,$course_id)
    {

        $user = CoursesGroup::where('course_id',$course_id)->where('group_id',$group_id)->first();

        $check = $user->delete();

        return redirect()->back()->with('error',__('pages.success-delete-join'));
    }


    public function addGroupFromList($group_id,$course_id)
    {

        $coursesGroup = new CoursesGroup();
        $coursesGroup->course_id = $course_id;
        $coursesGroup->group_id = $group_id;
        $coursesGroup->save();

        return redirect()->back()->with('error',__('pages.success-join'));
    }



}
