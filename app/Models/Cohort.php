<?php

namespace App\Models;

use App\User;

use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'max_trainees',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
    ];

    public function trainees()
    {
        return $this->belongsToMany(User::class, 'cohort_trainees', 'cohort_id', 'user_id')
            ->withTimestamps();
    }

    public function getTraineesCountAttribute()
    {
        return $this->trainees()->count();
    }

    // public function hasAvailableSlots()
    // {
    //     return $this->trainees_count < $this->max_trainees;
    // }

    public function isActive()
    {
        return $this->status == 1;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function registrationsCount()
    {
        return $this->registrations()->where('status', 'approved')->count();
    }

    public function hasAvailableSlots()
    {
        return $this->registrations()->where('status', 'approved')->count() < $this->max_trainees;
    }

    public function remainingSlots()
    {
        return $this->max_trainees - $this->registrations()->where('status', 'approved')->count();
    }
}