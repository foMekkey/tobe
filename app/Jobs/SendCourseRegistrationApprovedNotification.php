<?php

namespace App\Jobs;

use App\Models\CourseRegistration;
use App\Mail\CourseRegistrationApproved;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendCourseRegistrationApprovedNotification implements ShouldQueue
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
        // إرسال البريد الإلكتروني للمستخدم
        Mail::to($this->registration->email)
            ->send(new CourseRegistrationApproved($this->registration));
    }
}
