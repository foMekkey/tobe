<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $appends = ['lang_name'];
    
    public function getLangNameAttribute()
    {
        return __('pages.language-' . $this->lang);
    }
}
