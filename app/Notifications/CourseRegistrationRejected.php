<?php

namespace App\Notifications;

use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseRegistrationRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $registration;
    protected $reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CourseRegistration $registration, $reason = null)
    {
        $this->registration = $registration;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $message = 'تم رفض طلبك للانضمام إلى دورة "' . ($this->registration->course->name ?? 'الدورة المطلوبة') . '"';

        if ($this->reason) {
            $message .= '. السبب: ' . $this->reason;
        }

        return [
            'id' => $this->registration->id,
            'title' => 'تم رفض طلب التسجيل',
            'message' => $message,
            'type' => 2, // نوع الإشعار
            'link' => route('student.registrations.show', $this->registration->id),
            'datetime' => now(),
        ];
    }
}
