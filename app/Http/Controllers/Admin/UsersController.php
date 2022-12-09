<?php

namespace App\Http\Controllers\Admin;

use App\Courses;
use App\CoursesUser;
use App\DataTables\UsersDatatable;
use App\File;
use App\GroupMember;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use App\Role;
use App\Http\Controllers\Controller;
use Response;

class UsersController extends Controller
{
    public function index(UsersDatatable $usersDatatable)
    {
        return $usersDatatable->render('backend.users.index');
    }

    public function create()
    {
        $roles = Role::select('id', 'role')->get();
        return view('backend.users.create', compact('roles'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'f_name'      => 'required',
            'l_name'      => 'required',
            'user_name'   => 'required',
            'email'       => 'max:190|unique:users',
            'password'    => 'required',
            'type'    => 'required'
        ], [
            'f_name.required' => 'الإسم الاول مطلوب',
            'l_name.required' => 'الإسم الثاني مطلوب',
            'user_name.required' => 'إسم المستخدم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.unique' => 'البريد الإلكتروني موجود مسبقا',
        ]);

        if (isset($request->image)) {
            $image =   $request->image->store('users');
        } else {
            $image = '';
        }
        $users = new User();
        $users->l_name = $request->l_name;
        $users->f_name = $request->f_name;
        $users->user_name = $request->user_name;
        $users->email = $request->email;
        $users->bio = $request->bio;
        $users->certificates = $request->certificates;
        $users->type = $request->type;
        $users->role = $request->type;
        $users->tags = $request->tags;
        $users->status = $request->status;
        $users->password = bcrypt($request->password);
        $users->image = $image;
        $users->save();

        return redirect('users')->with(['success' =>  __('pages.success-add')]);
    }

    public function edit($id)
    {
        $users = User::find($id);
        return view('backend.users.edit', compact('users'));
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
            'l_name' => 'required',
            'f_name' => 'required',
            'user_name' => 'required',
            'email' => 'required',
            'type' => 'required',
        ]);


        $users = User::find($id);

        if ($request->password == null && !isset($request->password)) {
            $password = $users->password;
        } else {
            $password = bcrypt($request->password);
        }

        if (isset($request->status) ||  $request->status != null) {
            $stauts = $request->status;
        } else {
            $stauts = 0;
        }

        $users->l_name = $request->l_name;
        $users->f_name = $request->f_name;
        $users->user_name = $request->user_name;
        $users->email = $request->email;
        $users->bio = $request->bio;
        $users->certificates = $request->certificates;
        $users->type = $request->type;
        $users->role = $request->type;
        $users->tags = $request->tags;
        $users->status = $stauts;
        $users->password = $password;
        $users->image = ($request->hasFile('image')) ? $request->image->store('users') : $users->image;
        $users->update();

        return redirect('users')->with(['success' =>  __('pages.success-edit')]);
    }


    public function destroy($id)
    {

        $user = User::find($id);

        $check = $user->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));
        }
    }


    public function uploadFile(Request $request, $id)
    {
        $users = User::find($id);
        $files = new File();

        $file = $request->file('FileUploaded');
        $files->url = $request->FileUploaded->store('files');
        $files->owner_type = $users->type;
        $files->owner_id = $id;
        $files->extension = $file->getClientOriginalExtension();
        $files->file_size = $file->getSize();
        $files->mime = $file->getMimeType();
        $files->name = $file->getClientOriginalName();
        $files->user_id = $id;
        $files->save();

        return redirect()->back()->with(['success' =>  __('pages.success-add')]);
    }

    public function destroyCourseFromList($user_id, $course_id)
    {

        $user = CoursesUser::where('user_id', $user_id)->where('course_id', $course_id)->first();

        $check = $user->delete();

        return redirect()->back()->with('error', __('pages.success-delete'));
    }


    public function destroyGroupFromList($user_id, $group_id)
    {

        $group = GroupMember::where('student_id', $user_id)->where('group_id', $group_id)->first();

        $check = $group->delete();

        return redirect()->back()->with('error', __('pages.success-delete'));
    }

    public function DatatableCourses($id)
    {
        $courses = User::find($id)->courses;
        $users = User::find($id);
        return \DataTables::of($courses)
            ->editColumn('status', function ($query) {
                if ($query->status == 1) {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">فعال</span>';
                } else {
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">متوقف</span>';
                }
            })

            ->editColumn('start_date', function ($query) {
                return $query->start_date;
            })

            ->editColumn('user', function ($query) use ($users) {
                if ($users->type == 1) {
                    return '<span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">مسئول</span>';
                } elseif ($users->type == 2) {
                    return '<td><span class="kt-badge kt-badge--danger kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-danger">مدرب</span></td>';
                } else {
                    return '<span class="kt-badge kt-badge--primary kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-primary">طالب</span>';
                }
            })

            ->addColumn('options', function ($query)  use ($users) {
                $course_id = $query->id;
                $user_id = $users->id;
                return view('backend.users.actionCourses', compact('user_id', 'course_id'));
            })

            //            ->editColumn('options', 'backend.users.actionCourses')
            ->rawColumns(['user', 'options', 'status'])
            ->make(true);
    }

    public function DatatableUsersGroups($id)
    {
        $groups = User::find($id)->groups;
        $users = User::find($id);

        return \DataTables::of($groups)

            ->addColumn('options', function ($query)  use ($users) {
                $group_id = $query->id;
                $user_id = $users->id;
                return view('backend.users.actionGroups', compact('group_id', 'user_id'));
            })
            ->rawColumns(['options'])
            ->make(true);
    }


    public function DatatableUsersFiles($id)
    {
        $files = File::where('user_id', $id)->get();

        $users = User::find($id);

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
            ->addColumn('options', function ($query) use ($users) {
                $file_id = $query->id;
                $file = $query->url;
                $user_id = $users->id;
                $file_name = $query->name;
                return view('backend.users.actionFiles', compact('file_id', 'file', 'user_id', 'file_name'));
            })
            ->rawColumns(['options', 'is_active'])
            ->make(true);
    }


    public function updateFile(Request $request, $id, $user)
    {

        $this->validate($request, [
            'file' => 'required',
        ]);


        $files = File::find($id);

        $file = $request->file('file');
        $files->owner_id = $user;
        $files->url = $request->file->store('files');
        $files->extension = $file->getClientOriginalExtension();
        $files->file_size = $file->getSize();
        $files->mime = $file->getMimeType();
        $files->name = $file->getClientOriginalName();
        $files->update();

        return redirect()->back()->with(['success' =>  __('pages.success-add')]);
    }
}