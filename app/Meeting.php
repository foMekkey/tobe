<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\JoinMeetingParameters;
use Carbon\Carbon;

class Meeting extends Model
{
    protected $table = 'meetings';
    protected $fillable = ['user_id', 'name', 'date', 'time', 'message', 'period', 'meeting_with', 'meeting_with_id'];
    //protected $appends = ['join_url', 'is_running'];

    public function getJoinUrlAttribute()
    {
        if ($this->bbb_meeting_id && $this->date && $this->time && $this->period) {
            $currentTime = Carbon::now();
            $diff = $currentTime->diffInMinutes(Carbon::parse($this->date . ' ' . $this->time));
            if ($diff >= 0 && $diff < $this->period) {
                $pass = (auth()->user()->id == $this->user_id) ? 'mPass' : 'aPass';
                $bbb = new BigBlueButton();
                $joinMeetingParams = new JoinMeetingParameters($this->bbb_meeting_id, auth()->user()->user_name, $pass);
                $joinMeetingParams->setRedirect(true);
                $joinMeetingParams->setJoinViaHtml5(true);
                $meetingUrl = $bbb->getJoinMeetingURL($joinMeetingParams);

                return $meetingUrl;
            }
        }

        return '';
    }

    public function getIsRunningAttribute()
    {
        if ($this->date && $this->time && $this->period) {
            $currentTime = Carbon::now();
            $diff = $currentTime->diffInMinutes(Carbon::parse($this->date . ' ' . $this->time));
            if ($diff >= 0 && $diff < $this->period) {
                return '1';
            }
        }

        return '0';
    }
}
