<?php
namespace App\Http\Controllers\Trainer;

use App\DataTables\TrainerMeetingDatatable;
use App\Http\Controllers\Controller;
use App\Meeting;
use App\Groups;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Auth;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;

class MeetingsController extends Controller
{

    /**
     * @param TrainerMeetingDatatable $trainerMeetingDatatable
     * @return mixed
     */
    public function index(TrainerMeetingDatatable $trainerMeetingDatatable)
    {
        return $trainerMeetingDatatable->render('trainer.meeting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Groups::where('trainer_id',Auth::user()->id)->get();
    	$students = User::where('type',3)->get();

        return view('trainer.meeting.create',compact('groups','students'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'student_id' => 'required_if:meeting_with,1',
            'group_id' => 'required_if:meeting_with,2',
            'name'=>'required',
            'date'=>'required',
            'time'=>'required',
            'period'=>'required',
        ]);

        $mettings = new Meeting();
        $mettings->user_id           = auth()->id();
        $mettings->meeting_with      = $request->meeting_with;
        $mettings->meeting_with_id   = $request->meeting_with == '1' ? $request->student_id : $request->group_id;
        $mettings->name              = $request->name;
        $mettings->date              = Carbon::createFromFormat('m/d/Y', $request->date)->toDateTimeString();
        $mettings->time              = $request->time;
        $mettings->period            = $request->period;
        $mettings->message           = $request->message;
        $mettings->save();

        return redirect('trainer/meeting')->with(['success' =>  __('pages.success-add')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    public function ajaxShow($id)
    {
        $meeting = Meeting::find($id)->append('is_running')->toArray();

        return response()->json(['status' => 1, 'meeting' => $meeting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $groups = Groups::where('trainer_id',Auth::user()->id)->get();
    	$students = User::where('type',3)->get();

        $meetings = Meeting::find($id);
        $startdate =   Carbon::parse($meetings->date)->format('m/d/Y');
        return  view('trainer.meeting.edit',compact('meetings','startdate','groups','students'));
    }

    
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'student_id' => 'required_if:meeting_with,1',
            'group_id' => 'required_if:meeting_with,2',
            'name'=>'required',
            'date'=>'required',
            'time'=>'required',
            'period'=>'required',
        ]);

        $meetings = Meeting::find($id);
        $meetings->user_id           = auth()->id();
        $meetings->meeting_with      = $request->meeting_with;
        $meetings->meeting_with_id   = $request->meeting_with == '1' ? $request->student_id : $request->group_id;
        $meetings->name              = $request->name;
        $meetings->date              = Carbon::createFromFormat('m/d/Y', $request->date);
        $meetings->time              = $request->time;
        $meetings->period            = $request->period;
        $meetings->message           = $request->message;
        $meetings->update();

        return redirect('trainer/meeting')->with(['success' =>  __('pages.success-edit')]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $meetings = Meeting::find($id);

        $check = $meetings->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));

        }
    }

    public function start($id)
    {
        $meeting = Meeting::findOrFail($id);
        if (!$meeting->is_running) {
            return redirect('trainer/meeting')->with('error', __('pages.meeting-wrong-time'));
        }
        if ($meeting->bbb_meeting_id) {
            return redirect()->to($meeting->join_url);
        }
        $bbbMeetingId = $this->_createBBBMeeting($meeting);
        if ($bbbMeetingId != '') {
            $meeting->bbb_meeting_id = $bbbMeetingId;
            $meeting->save();

            return redirect()->to($meeting->join_url);
        }

        return redirect('trainer/meeting')->with('error', __('pages.bbb_creation_error'));
    }

    private function _createBBBMeeting($meeting)
    {
        $meetingId = 'c-' . $meeting->id . '-' . time();
        $meetingName = $meeting->name;
        $passwords = ['moderator' => 'mPass', 'attendee'  => 'aPass'];

        $bbb = new BigBlueButton();

        $createMeetingParams = new CreateMeetingParameters($meetingId, $meetingName);
        $createMeetingParams->setAttendeePassword($passwords['attendee']);
        $createMeetingParams->setModeratorPassword($passwords['moderator']);
        $createMeetingParams->setDuration(40);
        $createMeetingParams->setLogoutUrl('/');
        $createMeetingParams->setRecord(true);
        $createMeetingParams->setAllowStartStopRecording(true);
        $createMeetingParams->setAutoStartRecording(true);
        $createMeetingParams->setWelcomeMessage($meeting->message);
        $response = $bbb->createMeeting($createMeetingParams);
        if ($response->success()) {
            return $meetingId;
        }
        
        return '';
    }
}
