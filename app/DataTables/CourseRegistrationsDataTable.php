<?php

namespace App\DataTables;

use App\Models\CourseRegistration;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Carbon\Carbon;

class CourseRegistrationsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('user_name', function ($registration) {
                return $registration->user ? $registration->user->user_name : 'N/A';
            })
            ->addColumn('course_name', function ($registration) {
                return $registration->course ? $registration->course->name : 'N/A';
            })
            ->addColumn('cohort_name', function ($registration) {
                return $registration->cohort ? $registration->cohort->name : 'N/A';
            })
            ->editColumn('status', function ($registration) {
                $statusClasses = [
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger'
                ];

                $statusLabels = [
                    'pending' => 'قيد المراجعة',
                    'approved' => 'مقبول',
                    'rejected' => 'مرفوض'
                ];

                $class = $statusClasses[$registration->status] ?? 'secondary';
                $label = $statusLabels[$registration->status] ?? $registration->status;

                return '<span class="badge badge-' . $class . '">' . $label . '</span>';
            })
            ->editColumn('created_at', function ($registration) {
                return $registration->created_at->format('Y-m-d H:i');
            })
            ->addColumn('action', 'admin.course_registrations.datatables_actions')
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CourseRegistration $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CourseRegistration $model)
    {
        return $model->newQuery()
            ->with(['user', 'course', 'cohort'])
            ->select('course_registrations.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom'     => 'Blfrtip',
                'responsive' => true,
                'order'   => [[0, 'desc']],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'buttons' => [
                    [
                        'text' => '<i class="fa fa-download"></i>Excel',
                        'className' => 'dt-button buttons-excel buttons-html5 btn btn-default legitRipple',
                        'action' => "function ( e, dt, node, config ) {
                            window.location = '" . route('course-registrations.export') . "';
                        }"
                    ],
                    ['extend' => 'print', 'text' => '<i class="fa fa-print"></i>Print', 'className' => 'dt-button buttons-copy buttons-html5 btn btn-default legitRipple'],
                ],
                'language' => ['url' => asset('ar-datatable.json')],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('الرقم'),
            Column::make('user_name')->title('اسم المتقدم'),
            Column::make('course_name')->title('الدورة'),
            Column::make('cohort_name')->title('الفوج'),
            Column::make('status')->title('الحالة'),
            Column::make('created_at')->title('تاريخ التقديم'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
                ->title('الإجراءات'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'CourseRegistrations_' . date('YmdHis');
    }
}
