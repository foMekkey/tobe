<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * تحديد ما إذا كان المستخدم يمكنه تعديل المنشور
     */
    public function update(User $user, Post $post)
    {
        // المشرفون يمكنهم تعديل أي منشور
        if ($user->role == 1) {
            return true;
        }

        // المدربون يمكنهم تعديل منشوراتهم ومنشورات المتدربين في كورساتهم
        if ($user->role == 2) {
            if ($post->user_id == $user->id) {
                return true;
            }

            if ($post->community->type == 'course' && $post->community->course->user_id == $user->id) {
                return true;
            }
        }

        // المستخدمون العاديون يمكنهم تعديل منشوراتهم فقط
        return $post->user_id == $user->id;
    }

    /**
     * تحديد ما إذا كان المستخدم يمكنه حذف المنشور
     */
    public function delete(User $user, Post $post)
    {
        // المشرفون يمكنهم حذف أي منشور
        if ($user->role == 1) {
            return true;
        }

        // المدربون يمكنهم حذف منشوراتهم ومنشورات المتدربين في كورساتهم
        if ($user->role == 2) {
            if ($post->user_id == $user->id) {
                return true;
            }

            if ($post->community->type == 'course' && $post->community->course->user_id == $user->id) {
                return true;
            }
        }

        // المستخدمون العاديون يمكنهم حذف منشوراتهم فقط
        return $post->user_id == $user->id;
    }

    /**
     * تحديد ما إذا كان المستخدم يمكنه تثبيت المنشور
     */
    public function pin(User $user, Post $post)
    {
        // المشرفون يمكنهم تثبيت أي منشور
        if ($user->role == 1) {
            return true;
        }

        // المدربون يمكنهم تثبيت المنشورات في كورساتهم
        if ($user->role == 2) {
            if ($post->community->type == 'course' && $post->community->course->user_id == $user->id) {
                return true;
            }
        }

        return false;
    }
}
