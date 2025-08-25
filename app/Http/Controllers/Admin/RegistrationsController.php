<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\CourseRegistrationsDataTable;
use App\Repositories\CourseRegistrationRepositoryInterface;

class RegistrationsController extends Controller
{
    protected $registrationRepository;

    public function __construct(CourseRegistrationRepositoryInterface $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    public function index(CourseRegistrationsDataTable $dataTable)
    {
        return $dataTable->render('admin.course_registrations.index');
    }

    public function show($id)
    {
        $registration = $this->registrationRepository->find($id, ['course', 'cohort']);
        return view('admin.course_registrations.show', compact('registration'));
    }

    public function approve($id)
    {
        try {
            // Get the registration from the repository
            $registration = $this->registrationRepository->find($id);

            // Check if the course is free (cost = 0)
            $isFree = $registration->course && $registration->course->cost == 0;
            $autoEnrollMessage = '';

            // If the course is free and the user exists, automatically enroll them
            if ($isFree && $registration->user_id) {
                // Check if the user is already enrolled in the course
                $existingEnrollment = \DB::table('course_users')
                    ->where('course_id', $registration->course_id)
                    ->where('user_id', $registration->user_id)
                    ->first();

                if (!$existingEnrollment) {
                    // Add user to the course
                    \DB::table('course_users')->insert([
                        'course_id' => $registration->course_id,
                        'user_id' => $registration->user_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // If the course has a cohort, add the user to that cohort as well
                    if ($registration->cohort_id) {
                        // Check if the user is already in the cohort
                        $existingCohortUser = \DB::table('cohort_trainees')
                            ->where('cohort_id', $registration->cohort_id)
                            ->where('user_id', $registration->user_id)
                            ->first();

                        if (!$existingCohortUser) {
                            \DB::table('cohort_trainees')->insert([
                                'cohort_id' => $registration->cohort_id,
                                'user_id' => $registration->user_id,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }

                    $autoEnrollMessage = ' وتم إضافتك تلقائياً للدورة لأنها مجانية.';
                } else {
                    $autoEnrollMessage = ' (أنت مسجل بالفعل في هذه الدورة)';
                }
            }

            // Now approve the registration
            $registration = $this->registrationRepository->approve($id);

            // Send notifications
            \App\Jobs\SendCourseRegistrationApprovedNotification::dispatch($registration);
            \App\Jobs\SendAdminCourseRegistrationApprovedNotification::dispatch($registration);

            if ($registration->user_id) {
                $userNotification = new \App\UserNotification();
                $userNotification->user_id = $registration->user_id;
                $userNotification->message = 'تم قبول طلبك للانضمام إلى دورة "' .
                    ($registration->course->name ?? 'الدورة المطلوبة') . '"' . $autoEnrollMessage;
                $userNotification->type = 2; // نوع الإشعار: رابط
                $userNotification->related_type = 6; // نوع العنصر المرتبط
                $userNotification->related_id = $registration->id;
                $userNotification->datetime = now();
                $userNotification->read_at = null;
                $userNotification->save();
            }

            // إنشاء إشعار للمسؤولين
            $admins = \App\User::where('role', 1)->get(); // افتراض أن دور المسؤول هو 1
            foreach ($admins as $admin) {
                $adminNotification = new \App\UserNotification();
                $adminNotification->user_id = $admin->id;
                $adminNotification->message = 'تم قبول طلب تسجيل المستخدم "' .
                    $registration->full_name . '" في دورة "' .
                    ($registration->course->name ?? 'الدورة المطلوبة') . '"' .
                    ($autoEnrollMessage ? ' وتم إضافته تلقائياً للدورة لأنها مجانية.' : '');
                $adminNotification->type = 2; // نوع الإشعار: رابط
                $adminNotification->related_type = \App\UserNotification::RELATED_TYPE_COURSE_REGISTRATION; // نوع العنصر المرتبط
                $adminNotification->related_id = $registration->id;
                $adminNotification->datetime = now();
                $adminNotification->read_at = null;
                $adminNotification->save();
            }

            return redirect()->route('registrations.index')->with('success', 'تم قبول طلب التسجيل بنجاح.' .
                ($autoEnrollMessage ? ' وتم إضافة المستخدم تلقائياً للدورة لأنها مجانية.' : ''));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function reject($id)
    {
        $registration = $this->registrationRepository->reject($id);
        $reason = 'تم رفض طلب التسجيل بسبب عدم توافق الشروط';
        \App\Jobs\SendCourseRegistrationRejectedNotification::dispatch($registration, $reason);
        \App\Jobs\SendAdminCourseRegistrationRejectedNotification::dispatch($registration, $reason);
        // إنشاء رسالة الرفض
        $rejectMessage = 'تم رفض طلبك للانضمام إلى دورة "' . ($registration->course->name ?? 'الدورة المطلوبة') . '"';
        if ($reason) {
            $rejectMessage .= '. السبب: ' . $reason;
        }

        // إنشاء إشعار للمستخدم
        if ($registration->user_id) {
            $userNotification = new \App\UserNotification();
            $userNotification->user_id = $registration->user_id;
            $userNotification->message = $rejectMessage;
            $userNotification->type = 2; // نوع الإشعار: رابط
            $userNotification->related_type = \App\UserNotification::RELATED_TYPE_COURSE_REGISTRATION;; // نوع العنصر المرتبط
            $userNotification->related_id = $registration->id;
            $userNotification->datetime = now();
            $userNotification->read_at = null;
            $userNotification->save();
        }

        // إنشاء رسالة الرفض للمسؤول
        $adminRejectMessage = 'تم رفض طلب تسجيل المستخدم "' . $registration->full_name . '" في دورة "' . ($registration->course->name ?? 'الدورة المطلوبة') . '"';
        if ($reason) {
            $adminRejectMessage .= '. السبب: ' . $reason;
        }

        // إنشاء إشعار للمسؤولين
        $admins = \App\User::where('role', 1)->get(); // افتراض أن دور المسؤول هو 1
        foreach ($admins as $admin) {
            $adminNotification = new \App\UserNotification();
            $adminNotification->user_id = $admin->id;
            $adminNotification->message = $adminRejectMessage;
            $adminNotification->type = 2; // نوع الإشعار: رابط
            $adminNotification->related_type = 6; // نوع العنصر المرتبط
            $adminNotification->related_id = $registration->id;
            $adminNotification->datetime = now();
            $adminNotification->read_at = null;
            $adminNotification->save();
        }
        return redirect()->route('registrations.index')->with('success', 'تم رفض طلب التسجيل.');
    }
}
