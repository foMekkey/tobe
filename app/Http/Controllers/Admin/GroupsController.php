<?php

namespace App\Http\Controllers\Admin;

use App\CategoiresCourses;
use App\Courses;
use App\CoursesGroup;
use App\DataTables\GroupsDatatable;
use App\File;
use App\GroupMember;
use App\Groups;
use App\Http\Controllers\Controller;

use App\Http\Requests\GroupsRequest;
use App\User;
use Illuminate\Http\Request;
use Response;

class GroupsController extends Controller
{


    /**
     * @param GroupsDatatable $groupsDatatable
     * @return mixed
     */
    public function index(GroupsDatatable $groupsDatatable)
    {
        return $groupsDatatable->render('backend.groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trainers = User::where('type', 2)->pluck('user_name', 'id')->toArray();
        return view('backend.groups.create', compact('trainers'));
    }


    /**
     * @param GroupsRequest $groupsRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(GroupsRequest $groupsRequest)
    {

        if (isset($groupsRequest->status) ||  $groupsRequest->status != null) {
            $stauts = $groupsRequest->status;
        } else {
            $stauts = 0;
        }


        $groups = new Groups();
        $groups->name = $groupsRequest->name;
        $groups->desc = $groupsRequest->desc;
        $groups->status = $stauts;
        $groups->tags = $groupsRequest->tags;
        $groups->key = $groupsRequest->key;
        $groups->trainer_id = $groupsRequest->trainer_id;
        $groups->save();

        return redirect('groups')->with(['success' =>  __('pages.success-add')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $groups = Groups::find($id);
        // dd($groups);
        $trainers = User::where('type', 2)->pluck('user_name', 'id')->toArray();
        return view('backend.groups.edit', compact('groups', 'trainers'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'trainer_id' => 'required',
        ]);

        if (isset($request->status) || $request->status != null) {
            $stauts = $request->status;
        } else {
            $stauts = 0;
        }

        $groups = Groups::find($id);

        $groups->name = $request->name;
        $groups->desc = $request->desc;
        $groups->status = $stauts;
        $groups->tags = $request->tags;
        $groups->key = $request->key;
        $groups->trainer_id = $request->trainer_id;
        $groups->update();

        return redirect('groups')->with(['success' =>  __('pages.success-edit')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $courses = Courses::find($id);

        $check = $courses->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error',  __('pages.delete-success'));
        }
    }

    public function DatatableUsersGroups($id)
    {
        $users = User::get();
        $groups = Groups::find($id);

        return \DataTables::of($users)
            ->editColumn('type', function ($query) {
                if ($query->type == 1) {
                    return '<span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">مسئول</span>';
                } elseif ($query->type == 2) {
                    return '<td><span class="kt-badge kt-badge--danger kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-danger">مدرب</span></td>';
                } else {
                    return '<span class="kt-badge kt-badge--primary kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-primary">طالب</span>';
                }
            })
            ->addColumn('options', function ($query) use ($groups) {
                $student_id = $query->id;
                $group_id = $groups->id;
                return view('backend.groups.actionUsers', compact('group_id', 'student_id'));
            })
            ->rawColumns(['options', 'type'])
            ->make(true);
    }


    public function destroyGroupFromList($group_id, $student_id)
    {

        $user = GroupMember::where('student_id', $student_id)->where('group_id', $group_id)->first();

        $check = $user->delete();

        return redirect()->back()->with('error', __('pages.success-delete-join'));
    }


    public function addGroupFromList($group_id, $student_id)
    {

        $GroupMember = new GroupMember();
        $GroupMember->student_id = $student_id;
        $GroupMember->group_id = $group_id;
        $GroupMember->save();

        return redirect()->back()->with('error',  __('pages.success-join'));
    }


    //courses
    public function DatatableCoursesGroups($id)
    {
        $courses = Courses::get();
        $groups = Groups::find($id);

        return \DataTables::of($courses)
            ->editColumn('category_id', function ($query) {
                $category = CategoiresCourses::find($query->category_id);
                return $category['name'];
            })
            ->addColumn('options', function ($query) use ($groups) {
                $courses_id = $query->id;
                $group_id = $groups->id;
                return view('backend.groups.actionCourses', compact('group_id', 'courses_id'));
            })
            ->rawColumns(['options'])
            ->make(true);
    }


    public function destroyCourseFromList($group_id, $course_id)
    {

        $user = CoursesGroup::where('course_id', $course_id)->where('group_id', $group_id)->first();

        $check = $user->delete();

        return redirect()->back()->with('error', __('pages.success-delete-join'));
    }


    public function addCourseFromList($group_id, $course_id)
    {

        $CoursesGroup = new CoursesGroup();
        $CoursesGroup->course_id = $course_id;
        $CoursesGroup->group_id = $group_id;
        $CoursesGroup->save();

        return redirect()->back()->with('error',   __('pages.success-join'));
    }


    public function uploadFile(Request $request, $id)
    {

        $this->validate($request, [
            'FileUploaded' => 'required',
        ]);


        $groups = Groups::find($id);

        foreach ($request->FileUploaded as $key => $value) {
            echo $value->getClientOriginalExtension();
            $files = new File();
            $files->url = $value->storePublicly(
                path: 'groups/images',
                options: 'contabo'
            );
            $files->extension = $value->getClientOriginalExtension();
            $files->file_size = $value->getSize();
            $files->mime = $value->getMimeType();
            $files->name = $value->getClientOriginalName();
            $files->group_id = $groups->id;
            $files->save();
        }
        echo "<pre>";
        print_r($request->file('FileUploaded'));
        return;
        // return redirect()->back()->with(['success' =>  __('pages.success-add')]);
    }


    public function DatatableUsersFiles($id)
    {
        $files = File::where('group_id', $id)->get();
        $group = Groups::find($id);

        return \DataTables::of($files)
            ->editColumn('is_active', function ($query) {
                if ($query->is_active == 1) {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">يمكن للمستخدم رؤيته</span>';
                } else {
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">لا يمكن للمستخدم رؤيته</span>';
                }
            })
            ->editColumn('file_size', function ($query) {
                return formatSizeUnits($query->file_size);
            })
            ->addColumn('options', function ($query) use ($group) {
                $file_id = $query->id;
                $id_group = $group->id;
                $file = config("filesystems.disks.contabo.url") . '/' . $query->url;
                $file_name = $query->name;
                return view('backend.groups.actionFiles', compact('file_id', 'file', 'id_group', 'file_name'));
            })
            ->rawColumns(['options', 'is_active'])
            ->make(true);
    }
}