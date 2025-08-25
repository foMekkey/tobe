<?php

namespace App\Exports;

use App\Subscription;
use App\User;
use App\Courses;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubscriptionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Subscription::select('id', 'user_id', 'course_id', 'payment_method', 'status', 'created_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            __('pages.user'),
            __('pages.course'),
            __('pages.payment_method'),
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
        // الحصول على اسم المستخدم
        $user = User::find($row->user_id);
        $userName = $user ? $user->user_name : '';

        // الحصول على اسم الدورة
        $course = Courses::find($row->course_id);
        $courseName = $course ? $course->name : '';

        // تحديد طريقة الدفع
        $paymentMethod = '';
        if ($row->payment_method == 0) {
            $paymentMethod = __('pages.bank_transfer');
        } else {
            $paymentMethod = __('pages.e_wallet_transfer');
        }

        // تحديد الحالة
        $status = '';
        if ($row->status == 0) {
            $status = __('pages.pending');
        } else if ($row->status == 1) {
            $status = __('pages.accepted');
        } else {
            $status = __('pages.rejected');
        }

        return [
            $row->id,
            $userName,
            $courseName,
            $paymentMethod,
            $status,
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
