<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion_Comment extends Model
{
    protected $table = 'discussion_comments';

    public function User()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
}
