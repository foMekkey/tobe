<?php

namespace App\Mail;

use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCourseRegistrationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $adminName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CourseRegistration $registration, $adminName = null)
    {
        $this->registration = $registration;
        $this->adminName = $adminName ?: 'المسؤول';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تم قبول طلب انضمام للدورة - ' . config('app.name'))
            ->view('emails.admin-course-registration-approved');
    }
}
