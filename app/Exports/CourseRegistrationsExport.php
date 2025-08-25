<?php

namespace App\Exports;

use App\Models\CourseRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CourseRegistrationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CourseRegistration::with(['user', 'course', 'cohort'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'الرقم',
            'اسم المتقدم',
            'الدورة',
            'الفوج',
            'الحالة',
            'تاريخ التقديم'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        // تحديد الحالة
        $statusLabels = [
            'pending' => 'قيد المراجعة',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض'
        ];

        $status = $statusLabels[$row->status] ?? $row->status;

        return [
            $row->id,
            $row->user ? $row->user->user_name : 'N/A',
            $row->course ? $row->course->name : 'N/A',
            $row->cohort ? $row->cohort->name : 'N/A',
            $status,
            $row->created_at->format('Y-m-d H:i')
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // تنسيق الصف الأول (العناوين)
            1 => ['font' => ['bold' => true]],
        ];
    }
}
