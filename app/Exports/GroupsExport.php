<?php

namespace App\Exports;

use App\Groups;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GroupsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Groups::select('id', 'name', 'desc', 'status', 'created_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            __('pages.name-group'),
            __('pages.desc'),
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
        return [
            $row->id,
            $row->name,
            $row->desc,
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
