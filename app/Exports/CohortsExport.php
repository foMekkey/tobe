<?php

namespace App\Exports;

use App\Models\Cohort;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CohortsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Cohort::select('id', 'name', 'start_date', 'end_date', 'max_trainees', 'status', 'created_at')
            ->withCount('trainees')
            ->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'اسم الفوج',
            'تاريخ البداية',
            'تاريخ النهاية',
            'عدد المتدربين',
            'الحالة',
            'تاريخ الإنشاء'
        ];
    }

    public function map($cohort): array
    {
        return [
            $cohort->id,
            $cohort->name,
            $cohort->start_date->format('Y-m-d'),
            $cohort->end_date->format('Y-m-d'),
            $cohort->registrationsCount() . ' / ' . $cohort->max_trainees,
            $cohort->status ? 'مفعل' : 'غير مفعل',
            $cohort->created_at->format('Y-m-d')
        ];
    }
}
