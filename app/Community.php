<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cohort;
use App\Models\CourseRegistration;

class Community extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'reference_id',
        'cover_image',
        'is_active'
    ];

    /**
     * الحصول على الكورس المرتبط بالمجتمع إذا كان نوع المجتمع هو كورس
     */
    public function course()
    {
        if ($this->type === 'course') {
            return $this->belongsTo(Courses::class, 'reference_id');
        }
        return null;
    }

    /**
     * الحصول على الفوج المرتبط بالمجتمع إذا كان نوع المجتمع هو فوج
     */
    public function cohort()
    {
        if ($this->type === 'cohort') {
            return $this->belongsTo(Cohort::class, 'reference_id');
        }
        return null;
    }

    /**
     * الحصول على جميع المنشورات في المجتمع
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc');
    }

    /**
     * الحصول على جميع الرسائل في المجتمع
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * الحصول على جميع المستخدمين في المجتمع
     */
    public function members()
    {
        if ($this->type === 'course') {
            return $this->course->users();
        } else {
            return $this->cohort->trainees();
        }
    }

    /**
     * التحقق مما إذا كان المستخدم عضوًا في المجتمع
     */
    public function isMember($userId)
    {
        if ($this->type === 'course') {
            return $this->course->users()->where('users.id', $userId)->exists();
        } else {
            return $this->cohort->trainees()->where('users.id', $userId)->exists();
        }
    }

    /**
     * الحصول على اسم المرجع (الكورس أو الفوج)
     */
    public function getReferenceName()
    {
        if ($this->type === 'course') {
            $course = Courses::find($this->reference_id);
            return $course ? $course->name : 'غير محدد';
        } else {
            $cohort = Cohort::find($this->reference_id);
            return $cohort ? $cohort->name : 'غير محدد';
        }
    }
}