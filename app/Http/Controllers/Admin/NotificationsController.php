<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\NotificationDatatable;
use App\Event;
use App\Http\Requests\NotificationRequest;
use App\NotificationSetting;
use App\NotificationMessagesLog;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class NotificationsController extends Controller
{

    /**
     * @param NotificationDatatable $notificationDatatable
     * @return mixed
     */
    public function index(NotificationDatatable $notificationDatatable)
    {
        return $notificationDatatable->render('backend.notification.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $recivers = NotificationSetting::ReciverMessage();
        $events = Event::pluck('name', 'id')->toArray();
        $users = User::get();
        return view('backend.notification.create',compact('recivers','users','events'));
    }


    /**
     * @param NotificationRequest $notificationRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(NotificationRequest $notificationRequest)
    {

        if(isset($notificationRequest->status) ||  $notificationRequest->status != null)
        {
            $stauts = $notificationRequest->status;
        }else{
            $stauts = 0;
        }

        $notification = new NotificationSetting();
        $notification->name = $notificationRequest->name;
        $notification->notifications_event_id = $notificationRequest->notifications_event_id;
        $notification->status = $stauts;
        $notification->notifier = $notificationRequest->notifier;
        $notification->notification = $notificationRequest->notification;
        $notification->save();

        return redirect('notification')->with(['success' => 'تم الاضافة بنجاح']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notifications = NotificationSetting::find($id);
        $events = Event::pluck('name', 'id')->toArray();
        $recivers = NotificationSetting::ReciverMessage();
        return view('backend.notification.edit',compact('events','notifications','recivers'));
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
            'notifications_event_id' => 'required',
            'notifier' => 'required',
            'notification' => 'required',
        ]);

        if (isset($request->status) || $request->status != null) {
            $stauts = $request->status;
        } else {
            $stauts = 0;
        }

        $notifications = NotificationSetting::find($id);

        $notifications->name = $request->name;
        $notifications->notification = $request->notification;
        $notifications->status = $stauts;
        $notifications->notifier = $request->notifier;
        $notifications->notifications_event_id = $request->notifications_event_id;
        $notifications->update();

        return redirect('notification')->with(['success' =>  __('pages.success-add')]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notifications = NotificationSetting::find($id);

        $check = $notifications->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error',  __('pages.success-delete'));

        }
    }


    public function DatatableLogs()
    {
        $logs = NotificationMessagesLog::get();

        return \DataTables::of($logs)
            ->addColumn('options', function ($query) {
                $id = $query->id;
                return view('backend.notification.logsAction',compact('id'));
            })
            ->rawColumns(['options'])
            ->make(true);
    }


    public function destroyLogs($id)
    {
        $notificationsLogs = NotificationMessagesLog::find($id);

        $check = $notificationsLogs->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error',  __('pages.success-delete'));

        }
    }
}
