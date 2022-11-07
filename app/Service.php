<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $appends = ['lang_name'];
    
    public function getLangNameAttribute()
    {
        return __('pages.language-' . $this->lang);
    }
}
