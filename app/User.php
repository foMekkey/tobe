<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'l_name', 'f_name', 'user_name', 'email', 'password', 'bio', 'certificates', 'image', 'type', 'role', 'tags', 'status', 'points', 'badges_count', 'last_login_at', 'last_login_ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->belongsToMany(Courses::class, 'course_users', 'user_id', 'course_id');
    }

    public function roles()
    {
        return $this->hasOne(Role::class, 'id', 'type');
    }

    public function permissions()
    {
        return $this->roles->Permissions()->whereRaw("permissions not REGEXP 'get|update|destroy|datatable|post|add|store|edit|show|delete|send|surveys|site_|pages|contact|test|blog|consultations|news|lessons|replies|meeting|e_wallets|faqs'");
    }

    public function groups()
    {
        return $this->belongsToMany(Groups::class, 'group_members', 'student_id', 'group_id');
    }

    public function CoursesUsers()
    {
        return $this->belongsToMany(Courses::class, 'course_users', 'user_id', 'course_id')->withPivot('status', 'ended', 'datetime');
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class)->orderBy('id', 'desc')->limit(10);
    }

    public static function NameTrainer($id)
    {
        $user = User::find($id)->user_name;
        return $user;
    }

    public function getTypeLabelAttribute()
    {
        return __('pages.user_type.' . $this->type);
    }

    public function getEditLinkAttribute()
    {
        return '<a href="' . url('users/edit/' . $this->id) . '" target="_blank">' . $this->user_name . '</a>';
    }
}