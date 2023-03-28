<?php

namespace App\Http\Controllers\Trainer;

use App\Mission;
use App\MissionReply;
use App\Groups;
use App\User;
use App\SiteSetting;
use App\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\DataTables\TrainerMissionsDatatable;
use App\DataTables\TrainerMissionsRepliesDatatable;
use App\Http\Requests\MissionsRequest;
use Illuminate\Support\Facades\Mail;
use Auth;

class MissionController extends Controller
{
    /**
     * @param TrainerMissionsDatatable $missionsDatatable
     * @return mixed
     */
    public function index(TrainerMissionsDatatable $missionsDatatable)
    {
        return $missionsDatatable->render('trainer.missions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Groups::where('trainer_id', Auth::user()->id)->get();
        $students = User::where('type', 3)->get();

        return view('trainer.missions.create', compact('groups', 'students'));
    }


    /**
     * @param MissionsRequest $missionsRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(MissionsRequest $missionsRequest)
    {
        $mission = new Mission();
        $mission->user_id          = auth()->id();
        $mission->name             = $missionsRequest->name;
        $mission->desc             = $missionsRequest->desc;
        $mission->mission_to       = $missionsRequest->mission_to;
        $mission->mission_to_id    = $missionsRequest->mission_to == '1' ? $missionsRequest->student_id : $missionsRequest->group_id;
        $mission->period           = $missionsRequest->period;
        $mission->expire_date      = Carbon::createFromFormat('m/d/Y', $missionsRequest->expire_date);

        if (isset($missionsRequest->file) ||  $missionsRequest->file != null) {
            $mission->file =  $missionsRequest->file('file')->storePublicly(
                path: 'missions/files',
                options: 'contabo'
            );
        }

        $mission->save();

        $senderEmail = SiteSetting::where('name', 'email')->first()->value;
        $currentTime = Carbon::now();
        if ($missionsRequest->mission_to == '1') {
            $user = User::find($missionsRequest->student_id);
            Mail::send('emails.assigned_mission', ['mission' => $mission, 'user' => $user], function ($message) use ($user, $senderEmail) {
                $message->to($user->email)->from($senderEmail)->subject('مهمة جديدة !!');
            });

            $notificationData = [
                'type' => 2,
                'user_id' => $user->id,
                'message' => 'لقد تم تخصيص مهمة لك',
                'related_type' => 4,
                'related_id' => $mission->id,
                'datetime' => $currentTime
            ];
            UserNotification::insert($notificationData);
        } else {
            $userIds = \App\GroupMember::where('group_id', $missionsRequest->group_id)->pluck('student_id')->toArray();
            if ($userIds) {
                $users = User::whereIn('id', $userIds)->get();
                foreach ($users as $user) {
                    Mail::send('emails.assigned_mission', ['mission' => $mission, 'user' => $user], function ($message) use ($user, $senderEmail) {
                        $message->to($user->email)->from($senderEmail)->subject('مهمة جديدة !!');
                    });

                    $notificationData = [
                        'type' => 2,
                        'user_id' => $user->id,
                        'message' => 'لقد تم تخصيص مهمة لك',
                        'related_type' => 4,
                        'related_id' => $mission->id,
                        'datetime' => $currentTime
                    ];
                    UserNotification::insert($notificationData);
                }
            }
        }

        return redirect('trainer/missions')->with(['success' =>  __('pages.success-add')]);
    }

    public function replies($id, TrainerMissionsRepliesDatatable $trainerMissionsRepliesDatatable)
    {
        return $trainerMissionsRepliesDatatable->with('id', $id)->render('trainer.missions.replies');
    }

    public function showReply($id)
    {
        $reply = MissionReply::where('id', $id)->whereHas('mission', function ($q) {
            $q->user_id = auth()->user()->id;
        })->first();

        return view('trainer.missions.show-reply', compact('reply'));
    }

    public function updateReply($id, Request $request)
    {
        $this->validate($request, [
            'trainer_rate' => 'required|in:1,2,3,4,5',
            'status' => 'required|in:1,2'
        ]);

        $reply = MissionReply::where('id', $id)->whereHas('mission', function ($q) {
            $q->user_id = auth()->user()->id;
        })->first();

        if ($reply) {
            $reply->trainer_rate = $request->trainer_rate;
            $reply->trainer_comment = $request->trainer_comment;
            $reply->status = $request->status;
            $reply->save();

            return redirect(route('TrainerMissionsReplies', $reply->mission_id))->with(['success' =>  __('pages.success-trainer-rating-add')]);
        }

        return redirect()->back()->with('error', __('pages.unauthorized'));
    }
}