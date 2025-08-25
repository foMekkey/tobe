<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Cohort;
use App\Repositories\CohortRepository;

class CreateCohortRequest extends FormRequest
{
    /** @var CohortRepository */
    protected $cohortRepository;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->cohortRepository = app(CohortRepository::class);

        return [
            'name' => 'required|string|max:255|unique:cohorts,name',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'max_trainees' => 'required|integer|min:1|max:50',
            'status' => 'required|boolean',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->cohortRepository->datesOverlap($this->start_date, $this->end_date)) {
                $validator->errors()->add('start_date', 'التواريخ المحددة تتداخل مع فوج موجود بالفعل.');
                $validator->errors()->add('end_date', 'التواريخ المحددة تتداخل مع فوج موجود بالفعل.');
            }

            if (isset($this->cohort_id)) {
                $cohort = $this->cohortRepository->find($this->cohort_id);
                if ($cohort) {
                    $currentTraineesCount = $cohort->registrations()->where('status', 'approved')->count();
                    if ($currentTraineesCount >= $cohort->max_trainees) {
                        $validator->errors()->add('cohort_id', 'هذا الفوج مكتمل العدد ولا يمكن إضافة متدربين جدد.');
                    }
                }
            }
        });
    }

    public function isCohortFull(Cohort $cohort)
    {
        return $cohort->trainees()->count() >= $cohort->max_trainees;
    }
}