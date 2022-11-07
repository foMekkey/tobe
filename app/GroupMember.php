<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $table ='group_members';
    protected $fillable = ['group_id','student_id'];
}
