<?php

namespace App\Repositories;

use App\Models\Cohort;
use App\Repositories\BaseRepository;

class CohortRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'max_trainees',
        'status'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Cohort::class;
    }

    /**
     * Check if the given dates overlap with existing cohorts.
     *
     * @param string $startDate
     * @param string $endDate
     * @param int|null $excludeId
     * @return bool
     */
    public function datesOverlap($startDate, $endDate, $excludeId = null)
    {
        $query = $this->model->newQuery();

        // استبعاد الصف الحالي إذا تم تمرير معرف
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        // التحقق من تداخل التواريخ
        $overlapping = $query->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
        })->exists();

        return $overlapping;
    }
}
