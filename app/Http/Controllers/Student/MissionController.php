<?php

namespace App\Http\Controllers\Student;

use App\Mission;
use App\MissionReply;
use App\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\StudentMissionsDatatable;

class MissionController extends Controller
{
    /**
     * @param TrainerMissionsDatatable $missionsDatatable
     * @return mixed
     */
    public function index(StudentMissionsDatatable $missionsDatatable)
    {
        return $missionsDatatable->render('students.missions.index');
    }

    public function show($id)
    {
        $userGroups = \App\GroupMember::where('student_id', auth()->user()->id)->pluck('group_id')->toArray();

        $mission = Mission::where('id', $id)
            ->where(function ($q) use ($userGroups) {
                $q->where(function ($q1) {
                    $q1->where('mission_to', '1');
                    $q1->where('mission_to_id', auth()->user()->id);
                });
                $q->orWhere(function ($q2) use ($userGroups) {
                    $q2->where('mission_to', '2');
                    $q2->whereIn('mission_to_id', $userGroups);
                });
            })
            ->first();

        $reply = MissionReply::where('mission_id', $id)->first();

        var_dump($mission);
        var_dump($reply);
        return view('students.missions.show', compact('mission', 'reply'));
    }




    /*public function showReply($id)
    {
        $reply = MissionReply::where('id', $id)->whereHas('mission', function($q) {
            $q->user_id = auth()->user()->id;
        })->first();
        
        return view('trainer.missions.show-reply',compact('reply'));
    }*/

    public function addReply($missionId, Request $request)
    {
        $this->validate($request, [
            'reply' => 'required_without:file',
            'file' => 'required_without:reply'
        ]);

        $mission = Mission::findOrFail($missionId);
        $reply = MissionReply::where('mission_id', $missionId)->where('user_id', auth()->user()->id)->first();

        $file = '';
        if (!$reply) {
            if (isset($request->file) ||  $request->file != null) {
                $file = $request->file->store('missions');
            }

            $data = [
                'mission_id' => $missionId,
                'user_id' => auth()->user()->id,
                'reply' => $request->reply ?? '',
                'file' => $file,
                'sent_at' => Carbon::now()
            ];
            $reply = MissionReply::create($data);

            $notificationData = [
                'type' => 2,
                'user_id' => $mission->user_id,
                'message' => 'تم ارسال رد على المهمة: ' . $mission->name,
                'related_type' => 5,
                'related_id' => $reply->id,
                'datetime' => Carbon::now()
            ];
            UserNotification::insert($notificationData);

            return redirect(route('StudentMissions'))->with(['success' => __('pages.success-mission-add-reply')]);
        }

        return redirect()->back()->with('error', __('pages.unauthorized'));
    }
}