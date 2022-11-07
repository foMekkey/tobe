<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $table = 'discussions';

    public function User()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function Course()
    {
    	return $this->belongsTo('App\Courses','course_id','id');
    }

    public function Comments()
    {
    	return $this->hasMany('App\Discussion_Comment','discussion_id','id');
    }
}
