<?php

namespace App\Http\Controllers\Student;
use App\EventCalender;
use App\Meeting;
use App\GroupMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Calendar;
use Response;

class EventsController extends Controller
{
    public function index()
    {
        $appointments = EventCalender::where('user_id', auth()->id())->get();
        $userGroups = GroupMember::where('student_id', auth()->id())->pluck('group_id')->toArray();
        $meetings = Meeting::where(['meeting_with' => 1, 'meeting_with_id' => auth()->id()])
                           ->orWhere(function($q) use($userGroups) {
                               $q->where('meeting_with', 2);
                               $q->whereIn('meeting_with_id', $userGroups);
                           })->get();

        return view('students.events.index', compact('appointments', 'meetings'));

    }

    public function ajaxUpdate(Request $request)
    {
        $appointment = EventCalender::findOrFail($request->event_id);
        $appointment->update($request->all());

        return response()->json(['appointment' => $appointment]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.events.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $events = new EventCalender();
        $events->user_id           = auth()->id();
        $events->start_date        = $request->start_date;
        $events->end_date          = $request->end_date;
        $events->name              = $request->name;
        $events->save();

        return response()->json(['success' =>  __('pages.success-add'),'event'=>$events]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        /*$events = EventCalender::find($id);
        $events->user_id           = auth()->id();
        $events->start_date        = $request->start_date;
        $events->end_date          = $request->end_date;
        $events->name              = $request->name;
        $events->update();

        return redirect('student/events')->with(['success' =>  __('pages.success-edit')]);*/

        $appointment = EventCalender::findOrFail($id);
        $appointment->update($request->all());

        return response()->json(['appointment' => $appointment]);
    }


    public function edit($id)
    {
        $events = EventCalender::find($id);

        return response()->json(['status' => 1,'event'=>$events]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courses = EventCalender::find($id);

        $check = $courses->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));
        }
    }

    public function ajaxMeetingShow($id)
    {
        $meeting = Meeting::find($id)->append('join_url')->toArray();

        return response()->json(['status' => 1, 'meeting' => $meeting]);
    }
}
