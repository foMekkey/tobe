<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CohortTraineesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $cohortId;

    public function __construct($cohortId)
    {
        $this->cohortId = $cohortId;
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return User::query()
            ->select('users.id', 'users.f_name', 'users.l_name', 'users.user_name', 'users.email', 'users.created_at')
            ->join('course_registrations', 'users.id', '=', 'course_registrations.user_id')
            ->where('course_registrations.cohort_id', $this->cohortId);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'الاسم الأول',
            'الاسم الأخير',
            'اسم المستخدم',
            'البريد الإلكتروني',
            'تاريخ التسجيل'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->f_name,
            $row->l_name,
            $row->user_name,
            $row->email,
            $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : ''
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}
