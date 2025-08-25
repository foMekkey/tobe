<?php

namespace App\Repositories;

use App\Models\CourseRegistration;
use App\Models\Cohort;
use Illuminate\Support\Facades\DB;

class CourseRegistrationRepository implements CourseRegistrationRepositoryInterface
{
    protected $model;

    public function __construct(CourseRegistration $courseRegistration)
    {
        $this->model = $courseRegistration;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id, $with = [])
    {
        return $this->model->with($with)->findOrFail($id);
    }

    public function create(array $data)
    {
        // التحقق من توفر أماكن في الفوج قبل إنشاء التسجيل
        $cohort = Cohort::findOrFail($data['cohort_id']);
        if (!$cohort->hasAvailableSlots()) {
            throw new \Exception('عذراً، لقد اكتمل عدد المتدربين في هذا الفوج. يرجى اختيار فوج آخر.');
        }

        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $registration = $this->find($id);
        $registration->update($data);
        return $registration;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function approve($id)
    {
        $registration = $this->find($id);

        // التحقق من توفر أماكن في الفوج
        if (!$registration->cohort->hasAvailableSlots()) {
            throw new \Exception('عذراً، لقد اكتمل عدد المتدربين في هذا الفوج.');
        }

        $registration->status = 'approved';
        $registration->save();

        // يمكن إضافة منطق إضافي هنا مثل إرسال إشعار للمستخدم

        return $registration;
    }

    public function reject($id)
    {
        $registration = $this->find($id);
        $registration->status = 'rejected';
        $registration->save();

        // يمكن إضافة منطق إضافي هنا مثل إرسال إشعار للمستخدم

        return $registration;
    }

    public function getPending()
    {
        return $this->model->where('status', 'pending')->get();
    }

    public function getByUser($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function getByCourse($courseId)
    {
        return $this->model->where('course_id', $courseId)->get();
    }

    public function getByCohort($cohortId)
    {
        return $this->model->where('cohort_id', $cohortId)->get();
    }

    public function getByUserAndCourse($userId, $courseId)
    {
        return $this->model->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();
    }
}
