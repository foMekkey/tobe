<?php

namespace App\Http\Controllers\Backend;

use App\Exports\CoursesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{
    // الطرق الموجودة...

    /**
     * تصدير الدورات إلى ملف Excel
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new CoursesExport, 'courses_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
