<?php

namespace App\Http\Controllers\Admin;


use App\DataTables\EventsDatatable;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Session;

class EventsController extends Controller
{

    /**
     * @param EventsDatatable $eventsDatatable
     * @return mixed
     */
    public function index(EventsDatatable $eventsDatatable)
    {
        return $eventsDatatable->render('backend.events.index');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $events = new Event();
        $events->name           = $request->name;
        $events->save();

        return response()->json(['success' =>  __('pages.success-add')]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $events = Event::find($id);
        $events->name   = $request->name;
        $events->update();

        return response()->json($events);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $events = Event::find($id);

        $check = $events->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error',  __('pages.delete-success'));

        }
    }
    
    public function storeForStudent(Request $request)
    {
        $events = new \App\EventCalender();
        $events->user_id    = $request->user_id;
        $events->name       = $request->name;
        $events->start_date = $request->start_date;
        $events->end_date   = $request->end_date;
        $events->save();

        Session::flash('success', __('pages.success-add'));
        
        return response()->json(['success' =>  __('pages.success-add')]);
    }
}
