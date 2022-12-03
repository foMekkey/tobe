<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getStatus()
    {
        if (auth()->user()->role == 3) {
            $reply = MissionReply::where('user_id', auth()->user()->id)->where('mission_id', $this->id)->first();
            if ($reply) {
                if ($reply->status == 1) {
                    return 'ينتظر المراجعة';
                } elseif ($reply->status == 2) {
                    return 'تم الإنجاز';
                }
            }

            return 'قيد التنفيذ';
        }

        return '';
    }
}