<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Cohort;
use App\Repositories\CohortRepository;

class UpdateCohortRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255|unique:cohorts,name,' . $id,
            'description' => 'nullable|string',
            'start_date' => 'required|date',
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
            $id = $this->route('id');
            if ($this->cohortRepository->datesOverlap($this->input('start_date'), $this->input('end_date'), $id)) {
                $validator->errors()->add('start_date', 'التواريخ المحددة تتداخل مع فوج موجود بالفعل.');
                $validator->errors()->add('end_date', 'التواريخ المحددة تتداخل مع فوج موجود بالفعل.');
            }
        });
    }
}