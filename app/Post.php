<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'community_id',
        'user_id',
        'content',
        'type',
        'media_url',
        'is_pinned',
        'publish_to_general'
    ];

    /**
     * الحصول على المجتمع الذي ينتمي إليه المنشور
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * الحصول على المستخدم الذي أنشأ المنشور
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * الحصول على جميع التعليقات على المنشور
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->orderBy('created_at', 'asc');
    }

    /**
     * الحصول على جميع الإعجابات على المنشور
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * التحقق مما إذا كان المستخدم قد أعجب بالمنشور
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