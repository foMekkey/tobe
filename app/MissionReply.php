<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionReply extends Model
{
    protected $guarded = [];
    
    public function mission(){
        return $this->belongsTo(Mission::class, 'mission_id', 'id');
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
