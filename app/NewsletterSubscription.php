<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    protected $primaryKey = 'email';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;
}
