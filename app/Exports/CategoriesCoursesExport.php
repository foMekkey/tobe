<?php

namespace App\Exports;

use App\CategoiresCourses;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoriesCoursesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CategoiresCourses::select('id', 'name', 'lang', 'created_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            __('pages.category-name'),
            __('pages.language'),
            __('pages.created_at')
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
            $row->name,
            $row->lang == 'ar' ? 'العربية' : 'الإنجليزية',
            $row?->created_at?->format('Y-m-d H:i:s')
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
