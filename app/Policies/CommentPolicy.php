<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * تحديد ما إذا كان المستخدم يمكنه تعديل التعليق
     */
    public function update(User $user, Comment $comment)
    {
        // المشرفون يمكنهم تعديل أي تعليق
        if ($user->role == 1) {
            return true;
        }

        // المدربون يمكنهم تعديل تعليقاتهم وتعليقات المتدربين في كورساتهم
        if ($user->role == 2) {
            if ($comment->user_id == $user->id) {
                return true;
            }

            if (
                $comment->post->community->type == 'course' &&
                $comment->post->community->course->user_id == $user->id
            ) {
                return true;
            }
        }

        // المستخدمون العاديون يمكنهم تعديل تعليقاتهم فقط
        return $comment->user_id == $user->id;
    }

    /**
     * تحديد ما إذا كان المستخدم يمكنه حذف التعليق
     */
    public function delete(User $user, Comment $comment)
    {
        // المشرفون يمكنهم حذف أي تعليق
        if ($user->role == 1) {
            return true;
        }

        // المدربون يمكنهم حذف تعليقاتهم وتعليقات المتدربين في كورساتهم
        if ($user->role == 2) {
            if ($comment->user_id == $user->id) {
                return true;
            }

            if (
                $comment->post->community->type == 'course' &&
                $comment->post->community->course->user_id == $user->id
            ) {
                return true;
            }
        }

        // المستخدمون العاديون يمكنهم حذف تعليقاتهم فقط
        return $comment->user_id == $user->id;
    }
}
