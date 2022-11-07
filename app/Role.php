<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function Permissions()
    {
        return $this->hasMany('App\Permission','role_id','id');
    }
}
