<?php

namespace App\Mail;

use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCourseRegistrationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $adminName;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CourseRegistration $registration, $reason = null, $adminName = null)
    {
        $this->registration = $registration;
        $this->reason = $reason;
        $this->adminName = $adminName ?: 'المسؤول';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تم رفض طلب انضمام للدورة - ' . config('app.name'))
            ->view('emails.admin-course-registration-rejected');
    }
}
