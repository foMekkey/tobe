<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';
    protected $guarded = [];
    public $timestamps = false;
    const RELATED_TYPE_COURSE_REGISTRATION = 7;

    public $types = [
        1 => 'text',
        2 => 'link',
    ];

    public $relatedTypes = [
        1 => 'user',
        2 => 'course',
        3 => 'group',
        4 => 'mission',
        5 => 'mission_reply',
        6 => 'consultation',
        7 => 'course_registration',
    ];

    public function getLink()
    {
        if ($this->type == 2) {
            if ($this->related_type == 4 && auth()->user()->role == 3) {
                return route('showMissionsStudent', $this->related_id);
            } elseif ($this->related_type == 5 && auth()->user()->role == 2) {
                return url('trainer/missions/show-reply/' . $this->related_id);
            } elseif ($this->related_type == 6 && auth()->user()->role == 3) {
                return url('consultations/show/' . $this->related_id);
            }
        }

        return '#';
    }
}
