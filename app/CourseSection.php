<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $table = 'courses_sections';
    protected $fillable = ['title','desc'];
}
