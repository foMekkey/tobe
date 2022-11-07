<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $table = 'notifications_settings';
    protected $fillable = ['name', 'notifications_event_id', 'notifier', 'notification', 'status'];

    public static function ReciverMessage()
    {
       return $recived = [
                '1' =>'مستخدم ذات الصلة',
                '2' =>'مالك الحساب',
                '3' =>' كبار المسئولين',
                '4' =>'مسئولو الفروع',
                '5' =>' مدربى الدورة التعليمية',
                '6' =>' متعلموا الدورة',
        ];
    }
}
