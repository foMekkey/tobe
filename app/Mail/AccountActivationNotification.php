<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountActivationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $editUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->editUrl = url('/users/edit/' . $user->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تفعيل حساب مستخدم - ' . config('app.name'))
            ->view('emails.account-activation-notification');
    }
}
