<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursesGroup extends Model
{
    protected $table = 'courses_group';
    protected $fillable = ['course_id','group_id'];
}
