<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Session;
use Response;
class PermissionsController extends Controller
{
    # permissions page
    public function PermissionsPage()
    {
    	$roles = Role::latest()->get();
    	return view('backend.permission.permission',compact('roles'));
    }

	#add permissions
	public function AddPermissions(Request $request)
	{
		$this->validate($request,[
			'role_name' =>'required|min:2|max:190',
		]);

		$role = new Role;
		$role->role = $request->role_name;
		$role->save();
		$permissions = $request->permissions;
		if(count($permissions) > 0)
		{
			foreach($permissions as $p)
			{
				$per = new Permission;
				$per->permissions = $p;
				$per->role_id = $role->id;
				$per->save();
			}
		}

		//Session::flash('success','تم الحفظ');
		return back()->with(['success' =>  __('pages.success-add')]);
	}

	#edit permission page
	public function EditPermissions($id)
	{
		$role = Role::with('Permissions')->findOrFail($id);
		return view('backend.permission.edit_permission',compact('role',$role));
	}

	#update permissions
	public function UpdatePermission(Request $request)
	{
		// dd($request->all());
		$role = Role::findOrFail($request->id);
		$role->role = $request->role_name;
		$role->save();

		if($request->id == 1)
		{
			Permission::where('role_id',$request->id)->delete();
			foreach($request->permissions as $per)
			{
				$permission = new Permission;
				$permission->permissions = $per;
				$permission->role_id = $role->id;
				$permission->save();
			}
			//Session::flash('success','تم حفظ التعديلات');

			return redirect('permissions')->with(['success' =>  __('pages.success-edit')]);
		}else
		{

			//Session::flash('danger','لم يتم حفظ التعديلات');
			return back()->with(['error' => __('pages.error-edit')]);
		}
	}


    public function DeletePermission($id)
    {
        $role = Role::find($id);

        $check = $role->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));

        }
    }
}
