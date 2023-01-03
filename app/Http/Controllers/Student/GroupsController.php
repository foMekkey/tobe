<?php

namespace App\Http\Controllers\Student;

use App\GroupMember;
use App\Groups;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\DataTables\StudentGroupsDataTable;

class GroupsController extends Controller
{
    public function index(StudentGroupsDataTable $groupsDatatable)
    {
        return $groupsDatatable->render('students.groups.index');
    }

    public function showGroup()
    {
        return view('students.groups.join');
    }

    public function JoinGroup(Request $request)
    {
        $group_id = Groups::where('key', $request->key)->first();

        if (isset($group_id) && $group_id !== null) {
            $group_member = new GroupMember();
            $group_member->group_id      = $group_id->id;
            $group_member->student_id      = auth()->id();
            $group_member->save();

            return redirect()->back()->with(['success' => __('pages.success-join')]);
        } else {

            return redirect()->back()->with(['error' => __('pages.check-key')]);
        }
    }

    public function show($id)
    {

        if (GroupMember::where('student_id', auth()->id())->where('group_id', $id)->first() == null) {
            return "ليست لديك الصلاحيه";
        }
        $groups = Groups::find($id);

        return view('students.groups.show', compact('groups'));
    }
}