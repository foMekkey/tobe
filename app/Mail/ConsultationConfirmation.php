<?php

namespace App\Mail;

use App\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConsultationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $consultation;

    /**
     * Create a new message instance.
     *
     * @param Consultation $consultation
     * @return void
     */
    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تأكيد استلام طلب الاستشارة')
            ->view('emails.consultation-confirmation-user');
    }
}
