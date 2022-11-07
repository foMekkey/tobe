<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTerms extends Model
{
    protected $table = 'courses_terms';
    protected $fillable =['course_id', 'rules_of_traversal', 'rules_of_achievement', 'learning_methods', 'collect_result'];
}
