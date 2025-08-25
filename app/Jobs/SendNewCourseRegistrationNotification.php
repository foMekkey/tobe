<?php

namespace App\Jobs;

use App\Models\CourseRegistration;
use App\Mail\NewCourseRegistrationNotification;
use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendNewCourseRegistrationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $registration;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CourseRegistration $registration)
    {
        $this->registration = $registration;
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
                ->send(new NewCourseRegistrationNotification($this->registration));
        }
    }
}
