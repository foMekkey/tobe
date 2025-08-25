<?php

namespace App\Mail;

use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCourseRegistrationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $viewUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CourseRegistration $registration)
    {
        $this->registration = $registration;
        $this->viewUrl = url('/registrations/show/' . $registration->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('طلب انضمام جديد للدورة - ' . config('app.name'))
            ->view('emails.new-course-registration-notification');
    }
}
