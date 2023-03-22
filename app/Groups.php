<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'groups';
    protected $fillable = ['name', 'desc', 'key', 'status', 'trainer_id', 'tags'];
}