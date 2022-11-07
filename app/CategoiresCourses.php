<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoiresCourses extends Model
{
    protected $table ='course_categories';
    protected $fillable = [
        'name', 'parent_id', 'courses_count', 'lang'
    ];
    
    public function courses()
    {
        return $this->hasMany(Courses::class, 'category_id', 'id');
    }
}
