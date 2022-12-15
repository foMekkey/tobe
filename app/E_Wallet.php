<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class E_Wallet extends Model
{
    protected $table = 'e_wallets';
    protected $fillable = ['number', 'company_name_ar', 'company_name_en', 'active'];
}
