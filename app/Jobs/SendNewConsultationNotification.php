<?php

namespace App\Jobs;

use App\Consultation;
use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewConsultationNotification;

class SendNewConsultationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $consultation;

    /**
     * Create a new job instance.
     *
     * @param Consultation $consultation
     * @return void
     */
    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
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
            Mail::to($notificationEmail->value)
                ->send(new NewConsultationNotification($this->consultation));
        }
    }
}
