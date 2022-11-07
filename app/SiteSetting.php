<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $primaryKey = 'name';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;
}
