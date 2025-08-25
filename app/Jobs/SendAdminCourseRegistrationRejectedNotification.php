<?php

namespace App\Jobs;

use App\Models\CourseRegistration;
use App\Mail\AdminCourseRegistrationRejected;
use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SendAdminCourseRegistrationRejectedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $registration;
    protected $reason;
    protected $adminName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CourseRegistration $registration, $reason = null, $adminName = null)
    {
        $this->registration = $registration;
        $this->reason = $reason;
        $this->adminName = $adminName ?: (Auth::check() ? Auth::user()->user_name : 'المسؤول');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // الحصول على إيميل استلام الإشعارات من الإعدادات
        $notificationEmail = Setting::where('name', 'notifications_email')->first();

        if ($notificationEmail && !empty($notificationEmail->value)) {
            // إرسال البريد الإلكتروني
            Mail::to($notificationEmail->value)
                ->send(new AdminCourseRegistrationRejected($this->registration, $this->reason, $this->adminName));
        }
    }
}
