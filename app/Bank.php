<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';
    protected $fillable = ['bank_name_ar', 'bank_name_en', 'acc_name_ar', 'acc_name_en', 'acc_num','iban','active'];
}
