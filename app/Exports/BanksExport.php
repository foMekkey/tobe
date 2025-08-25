<?php

namespace App\Exports;

use App\Bank;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BanksExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Bank::select('id', 'bank_name_ar', 'bank_name_en', 'acc_name_ar', 'acc_name_en', 'acc_num', 'iban', 'active', 'created_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            __('pages.bank_name_ar'),
            __('pages.bank_name_en'),
            __('pages.acc_name_ar'),
            __('pages.acc_name_en'),
            __('pages.acc_num'),
            __('pages.iban'),
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
            $row->bank_name_ar,
            $row->bank_name_en,
            $row->acc_name_ar,
            $row->acc_name_en,
            $row->acc_num,
            $row->iban,
            $row->active == 1 ? __('pages.active') : __('pages.inactive'),
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
