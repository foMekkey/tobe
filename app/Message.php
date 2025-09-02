<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'community_id',
        'user_id',
        'content',
        'attachment',
        'attachment_type',
        'is_read'
    ];

    /**
     * الحصول على المجتمع الذي تنتمي إليه الرسالة
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * الحصول على المستخدم الذي أرسل الرسالة
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
