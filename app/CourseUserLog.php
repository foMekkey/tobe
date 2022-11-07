<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseUserLog extends Model
{
    protected $table = 'course_user_logs';

    protected $fillable = [
        'course_user_id', 'course_lesson_id', 'status', 'created_at', 'updated_at'
    ];

    public function lesson()
    {
        return $this->belongsTo(CoursesLessons::class,'course_lesson_id');
    }

}
