<?php

namespace App\Exports;

use App\Courses;
use App\CategoiresCourses;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CoursesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Courses::select('id', 'lang', 'name', 'user_id', 'category_id', 'price', 'status', 'created_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            __('pages.language'),
            __('pages.course-name'),
            __('pages.author'),
            __('pages.category'),
            __('pages.price'),
            __('pages.status'),
            __('pages.register_at')
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        // الحصول على اسم الفئة
        $category = CategoiresCourses::find($row->category_id);
        $categoryName = $category ? $category->name : '';

        // الحصول على اسم المؤلف
        $user = User::find($row->user_id);
        $authorName = $user ? $user->user_name : '';

        return [
            $row->id,
            $row->lang == 'ar' ? 'العربية' : 'الإنجليزية',
            $row->name,
            $authorName,
            $categoryName,
            $row->price,
            $row->status == 1 ? __('pages.active') : __('pages.inactive'),
            $row->created_at->format('Y-m-d H:i:s')
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
