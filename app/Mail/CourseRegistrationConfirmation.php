<?php

namespace App\Mail;

use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseRegistrationConfirmation extends Mailable
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
        // $this->viewUrl = route('student.registrations.show', $registration->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تأكيد استلام طلب الانضمام للدورة - ' . config('app.name'))
            ->view('emails.course-registration-confirmation');
    }
}
