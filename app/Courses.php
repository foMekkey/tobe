<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $table ='courses';

    protected $fillable = [
        'user_id', 'category_id', 'lang', 'name', 'level', 'desc', 'content','price', 'status', 'image', 'tags', 'hide_from_catalog', 'start_date', 'end_date', 'duration', 'rules', 'complete_rules', 'created_at', 'updated_at'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'course_users', 'course_id', 'user_id')->withPivot('status','ended','datetime');
    }

    public function category(){
        return $this->belongsTo(CategoiresCourses::class, 'category_id', 'id');
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function lessons()
    {
        return $this->hasMany(CoursesLessons::class, 'course_id', 'id');
    }
}
