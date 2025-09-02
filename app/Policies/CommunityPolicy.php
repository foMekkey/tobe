<?php

namespace App\Policies;

use App\User;
use App\Community;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommunityPolicy
{
    use HandlesAuthorization;

    /**
     * تحديد ما إذا كان المستخدم يمكنه عرض المجتمع
     */
    public function view(User $user, Community $community)
    {
        // المشرفون يمكنهم الوصول إلى جميع المجتمعات
        if ($user->role == 1) {
            return true;
        }

        // التحقق من نوع المجتمع
        if ($community->type == 'course') {
            // التحقق مما إذا كان المستخدم هو مدرب الكورس
            if ($community->course->user_id == $user->id) {
                return true;
            }

            // التحقق مما إذا كان المستخدم مسجل في الكورس
            return $community->course->users->contains($user->id);
        } else if ($community->type == 'cohort') {
            // التحقق مما إذا كان المستخدم مسجل في الفوج
            return $community->cohort->trainees->contains($user->id);
        }

        return false;
    }
}
