<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    protected $fillable = ['course_id', 'rate', 'review', 'name', 'email', 'datetime'];
    public $timestamps = false;
    
    public function course(){
        return $this->belongsTo(Courses::class);
    }
}
