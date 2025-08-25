<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CourseRegistrationRepositoryInterface;
use App\Repositories\CohortRepositoryInterface;
use App\Repositories\CoursesRepositoryInterface;
use App\DataTables\CourseRegistrationsDataTable;
use App\Models\CourseRegistration;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegistrationStatusChanged;
use App\Exports\CourseRegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;

class CourseRegistrationsController extends Controller
{
    protected $registrationRepository;

    public function __construct(
        CourseRegistrationRepositoryInterface $registrationRepository,
    ) {
        $this->registrationRepository = $registrationRepository;
    }

    /**
     * عرض قائمة طلبات التسجيل
     */
    public function index(CourseRegistrationsDataTable $dataTable)
    {
        return $dataTable->render('admin.course_registrations.index');
    }

    /**
     * عرض تفاصيل طلب تسجيل
     */
    public function show($id)
    {
        $registration = $this->registrationRepository->find($id);

        if (!$registration) {
            return redirect()->route('admin.course_registrations.index')
                ->with('error', 'طلب التسجيل غير موجود');
        }

        $course = $this->coursesRepository->find($registration->course_id);
        $cohort = $this->cohortRepository->find($registration->cohort_id);

        return view('admin.course_registrations.show', compact('registration', 'course', 'cohort'));
    }

    /**
     * قبول طلب التسجيل
     */
    public function approve($id)
    {
        try {
            $registration = $this->registrationRepository->find($id);

            if (!$registration) {
                return redirect()->route('admin.course_registrations.index')
                    ->with('error', 'طلب التسجيل غير موجود');
            }

            // التحقق من توفر مقاعد في الفوج
            $cohort = $this->cohortRepository->find($registration->cohort_id);
            if (!$cohort->hasAvailableSlots()) {
                return redirect()->route('admin.course_registrations.show', $id)
                    ->with('error', 'لا توجد مقاعد متاحة في الفوج المحدد');
            }

            // تحديث حالة الطلب إلى "مقبول"
            $this->registrationRepository->approve($id);
            // إرسال إشعار للمستخدم
            \App\Jobs\SendCourseRegistrationApprovedNotification::dispatch($registration);

            // إرسال إشعار للمسؤول
            \App\Jobs\SendAdminCourseRegistrationApprovedNotification::dispatch($registration);
            // إرسال إشعار للمستخدم
            // $registration->user->notify(new RegistrationStatusChanged($registration, 'approved'));

            return redirect()->route('admin.course_registrations.index')
                ->with('success', 'تم قبول طلب التسجيل بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.course_registrations.index')
                ->with('error', 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage());
        }
    }

    /**
     * رفض طلب التسجيل
     */
    public function reject(Request $request, $id)
    {
        try {
            $registration = $this->registrationRepository->find($id);

            if (!$registration) {
                return redirect()->route('admin.course_registrations.index')
                    ->with('error', 'طلب التسجيل غير موجود');
            }

            // تحديث حالة الطلب إلى "مرفوض"
            $this->registrationRepository->reject($id, $request->rejection_reason);

            // إرسال إشعار للمستخدم
            // $registration->user->notify(new RegistrationStatusChanged($registration, 'rejected', $request->rejection_reason));

            // إرسال إشعار للمستخدم
            \App\Jobs\SendCourseRegistrationRejectedNotification::dispatch($registration, $reason);

            // إرسال إشعار للمسؤول
            \App\Jobs\SendAdminCourseRegistrationRejectedNotification::dispatch($registration, $reason);

            return redirect()->route('admin.course_registrations.index')
                ->with('success', 'تم رفض طلب التسجيل بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.course_registrations.index')
                ->with('error', 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new CourseRegistrationsExport, 'course_registrations_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
