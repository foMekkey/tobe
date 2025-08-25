<?php

namespace App\Jobs;

use App\ContactMessage;
use App\Mail\ContactMessageConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendContactMessageConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contactMessage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // إرسال البريد الإلكتروني للمرسل
        Mail::to($this->contactMessage->email)
            ->send(new ContactMessageConfirmation($this->contactMessage));
    }
}
