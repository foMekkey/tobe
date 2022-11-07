<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'notification_events';
    protected $fillable = ['name'];
}
