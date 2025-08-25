<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Courses;

class CourseRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'cohort_id',
        'full_name',
        'birth_date',
        'education',
        'previous_courses',
        'current_job',
        'additional_tasks',
        'join_date',
        'special_skills',
        'communication_problems',
        'personal_problems',
        'skills_to_develop',
        'message_to_consultant',
        'mobile_number',
        'whatsapp_number',
        'email',
        'status'
    ];

    protected $dates = [
        'birth_date',
        'join_date'
    ];

    // تشفير المشكلات الشخصية قبل الحفظ
    public function setPersonalProblemsAttribute($value)
    {
        $this->attributes['personal_problems'] = !empty($value) ? Crypt::encryptString($value) : null;
    }

    // فك تشفير المشكلات الشخصية عند الاسترجاع
    public function getPersonalProblemsAttribute($value)
    {
        return !empty($value) ? Crypt::decryptString($value) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
