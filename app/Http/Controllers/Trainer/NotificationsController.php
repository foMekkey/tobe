<?php

namespace App\Http\Controllers\Trainer;
use App\User;
use App\Courses;
use App\Groups;
use App\UserNotification;
use App\SiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Auth;
use File;
use URL;
use Mail;

class notificationsController extends Controller
{
    public function index()
    {
    	$groups = Groups::where('trainer_id',Auth::user()->id)->get();
    	$students = User::where('type',3)->get();
        return view('trainer.notifications.notifications',compact('groups','students'));
    }

    public function Send(Request $request)
    {
        $senderEmail = SiteSetting::where('name', 'email')->first()->value;
        $currentTime = Carbon::now();
    	if ($request->students && count($request->students) > 0) {
            $users = User::whereIn('id', $request->students)->get();
            foreach ($users as $user) {
                Mail::send('emails.notification', ['content' => $request->body], function ($message) use($user, $senderEmail) {
                    $message->to($user->email)->from($senderEmail)->subject('اشعار جديد!!');
                });

                $notificationData = [
                    'type' => 1,
                    'user_id' => $user->id,
                    'message' => $request->body,
                    'related_type' => 0,
                    'datetime' => $currentTime
                ];
                UserNotification::insert($notificationData);
            }
        } 
        
        if ($request->groups && count($request->groups) > 0) {
            $userIds = \App\GroupMember::whereIn('group_id', $request->groups)->pluck('student_id')->toArray();
            if ($userIds) {
                $users = User::whereIn('id', $userIds)->get();
                foreach ($users as $user) {
                    Mail::send('emails.notification', ['content' => $request->body], function ($message) use($user, $senderEmail) {
                        $message->to($user->email)->from($senderEmail)->subject('اشعار جديد!!');
                    });
                    
                    $notificationData = [
                        'type' => 2,
                        'user_id' => $user->id,
                        'message' => $request->body,
                        'related_type' => 0,
                        'datetime' => $currentTime
                    ];
                    UserNotification::insert($notificationData);
                }
            }
        }
        
        return redirect('trainer/notifications')->with(['success' =>  __('pages.success-add')]);
    }
}
