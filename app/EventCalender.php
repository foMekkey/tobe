<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCalender extends Model
{
    protected $table = 'events';
    protected $fillable = ['name','start_date','end_date'];
}
