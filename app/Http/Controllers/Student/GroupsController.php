<?php

namespace App\Http\Controllers\Student;
use App\GroupMember;
use App\Groups;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class GroupsController extends Controller
{
    public function showGroup()
    {
        return view('students.groups.show');
    }

    public function JoinGroup(Request $request)
    {
        $group_id = Groups::where('key',$request->key)->first();

        if(isset($group_id) && $group_id !== null){
            $group_member = new GroupMember();
            $group_member->group_id      = $group_id->id;
            $group_member->student_id      = auth()->id();
            $group_member->save();

            return redirect()->back()->with(['success' => __('pages.success-join')]);

        }else{

            return redirect()->back()->with(['error' => __('pages.check-key')]);

        }
    }
}
