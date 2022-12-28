<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';
    protected $guarded = [];

    public function getImageAttribute()
    {
        return config('filessystems/disks.contabo.url') . $this->image;
    }
}