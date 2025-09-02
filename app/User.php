<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Cohort;
use App\Models\CourseRegistration;
use Cache;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'l_name',
        'f_name',
        'user_name',
        'email',
        'password',
        'bio',
        'certificates',
        'image',
        'type',
        'role',
        'tags',
        'status',
        'points',
        'badges_count',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
        'activation_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        return $this->roles->Permissions()->whereRaw("permissions not REGEXP 'get|update|destroy|datatable|post|add|store|edit|show|delete|send|surveys|site_|pages|contact|test|blog|consultations|news|lessons|replies|meeting|e_wallets|StudentSubscription|faqs|banks|create|removeTrainee|approve|reject|filter|export|join_course'")->distinct('permissions');
    }

    public function groups()
    {
        return $this->belongsToMany(Groups::class, 'group_members', 'student_id', 'group_id');
    }

    public function group()
    {
        $groupMember =  GroupMember::where('student_id', $this->id)->first()->group_id ?? null;
        if ($groupMember) {
            return Groups::find($groupMember)->name;
        }
        return "";
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

    public function cohorts()
    {
        return $this->belongsToMany(Cohort::class, 'cohort_trainees', 'user_id', 'cohort_id');
    }
    /**
     * Get the course registrations for the user.
     */
    public function courseRegistrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    /**
     * الحصول على جميع المنشورات التي أنشأها المستخدم
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * الحصول على جميع التعليقات التي أنشأها المستخدم
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * الحصول على جميع الإعجابات التي قام بها المستخدم
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * الحصول على جميع الرسائل التي أرسلها المستخدم
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * الحصول على مجتمعات المستخدم
     */
    public function communities()
    {
        $communities = collect();

        // الحصول على مجتمعات الكورسات
        $courseCommunities = Community::where('type', 'course')
            ->whereHas('course.users', function ($query) {
                $query->where('users.id', $this->id);
            })
            ->orWhereHas('course', function ($query) {
                $query->where('user_id', $this->id);
            })
            ->get();

        $communities = $communities->merge($courseCommunities);

        // الحصول على مجتمعات الأفواج
        $cohortCommunities = Community::where('type', 'cohort')
            ->whereHas('cohort.trainees', function ($query) {
                $query->where('users.id', $this->id);
            })
            ->get();

        $communities = $communities->merge($cohortCommunities);

        return $communities;
    }

    /**
     * تحديد ما إذا كان المستخدم متصل حالياً
     */
    public function getIsOnlineAttribute()
    {
        return Cache::has('user-online-' . $this->id);
    }

    public function getNameAttribute()
    {
        return $this->f_name . ' ' . $this->l_name;
    }
}