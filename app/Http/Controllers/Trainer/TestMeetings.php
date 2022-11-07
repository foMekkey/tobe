<?php

namespace App\Http\Controllers\Trainer;

use BigBlueButton\BigBlueButton;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use LaravelBigbluebutton\Bigbluebutton\Contracts\Meeting;


class TestMeetings extends Controller
{
    protected $meeting;

    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }
    /**
     *  Returns a list of meetings
     */
    public function all()
    {
        /*$meetings = $this->meeting->all();
        if ($meetings) {
            return $meetings;
        }*/

        $bbb = new BigBlueButton();
        $response = $bbb->getMeetings();
dd($response);
        if ($response->getReturnCode() == 'SUCCESS') {
            foreach ($response->getRawXml()->meetings->meeting as $meeting) {
                dd($meeting);
            }
        }
    }

    public function get()
    {
        $bbb = new BigBlueButton();

        $getMeetingInfoParams = new GetMeetingInfoParameters('fea7f657f56a2a448da7d4b535ee5e279caf3d9a-1579287973390', 'mPass');
        $response = $bbb->getMeetingInfo($getMeetingInfoParams);
        if ($response->getReturnCode() == 'FAILED') {
            // meeting not found or already closed
            dd($response);
        } else {
            dd($response->getRawXml());
        }
    }

    public function create(Request $request)
    {
        $meetingId = 'c-1-' . time();
        $meetingName ='اجتماع 1';

        /*$bbb                 = new BigBlueButton();
        $createMeetingParams = new CreateMeetingParameters($meetingId, $meetingName);
        $response            = $bbb->createMeeting($createMeetingParams);
        dd($response);
        dd("Created Meeting with ID: " . $response->getMeetingId());*/
        
        $passwords = array('moderator' => 'mPass',
            'attendee'  => 'aPass');

        $bbb = new BigBlueButton();
        
        $createMeetingParams = new CreateMeetingParameters($meetingId, $meetingName);
        $createMeetingParams->setAttendeePassword($passwords['attendee']);
        $createMeetingParams->setModeratorPassword($passwords['moderator']);
        $createMeetingParams->setDuration(40);
        $createMeetingParams->setLogoutUrl('/');
        $createMeetingParams->setRecord(true);
        $createMeetingParams->setAllowStartStopRecording(true);
        $createMeetingParams->setAutoStartRecording(true);
        $response = $bbb->createMeeting($createMeetingParams);
        //if ($response->getMeetingId() )
        dd($response);
        if ($bbb->createMeeting($createMeetingParams)) {
            return response()->json(['success' =>  __('pages.success-add')]);
        }else{
            return response()->json(['error' =>  __('pages.success-add')]);
        }
    }


    public function join($meetingId)
    {
        //$meetingId = '2222';
        $userName ='test';

        $bbb = new BigBlueButton();
        $joinMeetingParams = new JoinMeetingParameters($meetingId, $userName, 'mPass');
        $joinMeetingParams->setRedirect(true);
        $meetingUrl = $bbb->getJoinMeetingURL($joinMeetingParams);
        dd($meetingUrl);
        return redirect($meetingUrl);
    }

    public function close(Request $request)
    {
        $meetingId = '1';
        $passwords = array('moderator' => 'mPass',
            'attendee'  => 'aPass');

        $meetingParams = new EndMeetingParameters($meetingId, $passwords['moderator']);
        $this->meeting->close($meetingParams);
    }
}
