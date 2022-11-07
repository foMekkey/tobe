<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable =['owner_type', 'owner_id', 'extension', 'local_path', 'file_size', 'mime', 'thumbnail', 'url', 'is_active', 'name', 'user_id'];
}
