<?php

namespace App\Notifications;

use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCourseRegistrationApproved extends Notification implements ShouldQueue
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
            'title' => 'تم قبول طلب تسجيل',
            'message' => 'تم قبول طلب تسجيل المستخدم "' . $this->registration->full_name . '" في دورة "' . ($this->registration->course->name ?? 'الدورة المطلوبة') . '"',
            'type' => 2, // نوع الإشعار
            'link' => route('registrations.show', $this->registration->id),
            'datetime' => now(),
        ];
    }
}
