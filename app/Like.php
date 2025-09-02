<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'likeable_id',
        'likeable_type',
        'user_id'
    ];

    /**
     * الحصول على العنصر الذي تم الإعجاب به (منشور أو تعليق)
     */
    public function likeable()
    {
        return $this->morphTo();
    }

    /**
     * الحصول على المستخدم الذي قام بالإعجاب
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
