<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationMessagesLog extends Model
{
    protected $table = 'notification_message_logs';
    protected $fillable = ['email','content','send_at'];
}
