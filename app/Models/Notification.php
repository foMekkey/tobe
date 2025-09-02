<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'type',
        'link',
        'read_at',
        'datetime'
    ];

    protected $dates = [
        'read_at',
        'datetime',
        'created_at',
        'updated_at'
    ];

    /**
     * علاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * تحديد ما إذا كان الإشعار مقروءًا
     */
    public function isRead()
    {
        return $this->read_at !== null;
    }

    /**
     * تعيين الإشعار كمقروء
     */
    public function markAsRead()
    {
        if ($this->read_at === null) {
            $this->read_at = now();
            $this->save();
        }
    }

    /**
     * الحصول على رابط الإشعار
     */
    public function getLink()
    {
        return $this->link;
    }
}
