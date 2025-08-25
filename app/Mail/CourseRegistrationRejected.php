<?php

namespace App\Mail;

use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseRegistrationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CourseRegistration $registration, $reason = null)
    {
        $this->registration = $registration;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تم رفض طلب الانضمام للدورة - ' . config('app.name'))
            ->view('emails.course-registration-rejected');
    }
}
