<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursesUser extends Model
{
    protected $table = 'course_users';

    protected $fillable = [
        'user_id', 'course_id', 'status', 'ended', 'datetime', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_users', 'course_id', 'user_id')->withPivot('status', 'ended', 'datetime');
    }


    public function Courses()
    {
        return $this->belongsTo(Courses::class, 'course_id');
        // return $this->belongsToMany(Courses::class, 'course_users', 'course_id', 'user_id')->withPivot('status','ended','datetime');
    }

    public function courseGroups()
    {
        return $this->hasMany(CoursesGroup::class, "course_id", "course_id");
    }
}