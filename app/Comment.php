<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content'
    ];

    /**
     * الحصول على المنشور الذي ينتمي إليه التعليق
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * الحصول على المستخدم الذي أنشأ التعليق
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * الحصول على التعليق الأب إذا كان هذا التعليق رداً على تعليق آخر
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * الحصول على جميع الردود على هذا التعليق
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    /**
     * الحصول على جميع الإعجابات على التعليق
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * التحقق مما إذا كان المستخدم قد أعجب بالتعليق
     */
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function isLikedByUser($user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
}
