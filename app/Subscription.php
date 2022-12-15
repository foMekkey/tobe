<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $fillable = ['user_id', 'course_id','payment_method','amount','currency','bank_id','user_bank_acc_name','e_wallet_id','user_e_wallet_number','transfer_date', 'status'];
}
