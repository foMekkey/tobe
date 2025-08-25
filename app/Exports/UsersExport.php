<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('id', 'role', 'user_name', 'email', 'type', 'status', 'created_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            __('pages.role'),
            __('pages.user-name'),
            __('pages.email'),
            __('pages.user-type'),
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
        // تحديد نوع المستخدم
        $userType = '';
        if ($row->roles) {
            $userType = $row->roles->role;
        } else {
            $userType = __('pages.no-permission-detected');
        }

        return [
            $row->id,
            $row->role,
            $row->user_name,
            $row->email,
            $userType,
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
