<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursesGroup extends Model
{
    protected $table = 'courses_group';
    protected $fillable = ['course_id', 'group_id'];

    public function courseGroupMembers()
    {
        return $this->hasMany(GroupMember::class, "group_id", "group_id");
    }
}