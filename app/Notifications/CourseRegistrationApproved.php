<?php

namespace App\Notifications;

use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseRegistrationApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $registration;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CourseRegistration $registration)
    {
        $this->registration = $registration;
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
        return [
            'id' => $this->registration->id,
            'title' => 'تم قبول طلب التسجيل',
            'message' => 'تم قبول طلبك للانضمام إلى دورة "' . ($this->registration->course->name ?? 'الدورة المطلوبة') . '"',
            'type' => 2, // نوع الإشعار (يمكن تعديله حسب نظام الإشعارات لديك)
            'link' => route('student.registrations.show', $this->registration->id),
            'datetime' => now(),
        ];
    }
}
