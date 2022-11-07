<?php

namespace App\Http\Controllers\Trainer;
use App\EventCalender;
use App\Meeting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Calendar;
use Response;

class EventsController extends Controller
{
    public function index()
    {
        $appointments = EventCalender::where('user_id', auth()->id())->get();
        $meetings = Meeting::where('user_id', auth()->id())->get();
        
        return view('trainer.events.index', compact('appointments', 'meetings'));
    }

    public function ajaxUpdate($id, Request $request)
    {
        $appointment = EventCalender::findOrFail($id);
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
        return view('trainer.events.create');
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
        $events = EventCalender::find($id);
        $events->user_id           = auth()->id();
        $events->start_date        = $request->start_date;
        $events->end_date          = $request->end_date;
        $events->name              = $request->name;
        $events->update();

        return redirect('trainer/events')->with(['success' =>  __('pages.success-edit')]);
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
}
