<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CohortTraineesExport;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Asset;

class CohortTraineesDataTable extends DataTable
{
    protected $cohortId;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', function ($user) {
            return '<a href="' . route('cohorts.removeTrainee', [$this->cohortId, $user->id]) . '" 
                    class="btn btn-danger btn-sm" 
                    onclick="return confirm(\'هل أنت متأكد من إزالة هذا المتدرب من الفوج؟\')">
                    <i class="fa fa-trash"></i> إزالة
                </a>';
        })
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()
            ->select('users.id', 'users.user_name', 'users.email', 'users.created_at')
            ->join('course_registrations', 'users.id', '=', 'course_registrations.user_id')
            ->where('course_registrations.cohort_id', $this->cohortId);
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
            ->addAction(['width' => '120px', 'printable' => false, 'title' => 'الإجراءات'])
            ->parameters([
                'dom'     => 'Blfrtip',
                'responsive' => true,
                'order'   => [[0, 'desc']],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "الكل"]],
                'buttons' => [
                    [
                        'extend' => 'excel',
                        'text' => '<i class="fa fa-download"></i>Excel',
                        'className' => 'dt-button buttons-excel buttons-html5 btn btn-default legitRipple',
                        'exportOptions' => [
                            'columns' => ':visible:not(.not-export)'
                        ],
                        'action' => "function (e, dt, button, config) {
                            window.location = '" . route('cohorts.exportTrainees', ['id' => $this->cohortId]) . "';
                        }"
                    ],
                    [
                        'extend' => 'print',
                        'text' => '<i class="fa fa-print"></i>Print',
                        'className' => 'dt-button buttons-print btn btn-default legitRipple',
                        'exportOptions' => [
                            'columns' => ':visible:not(.not-export)'
                        ]
                    ],
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
            'id' => ['title' => '#', 'searchable' => false],
            'user_name' => ['title' => 'الاسم'],
            'email' => ['title' => 'البريد الإلكتروني'],
            'created_at' => ['title' => 'تاريخ التسجيل']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'cohort_trainees_' . date('YmdHis');
    }

    /**
     * Set cohort ID
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if ($key === 'cohortId') {
            $this->cohortId = $value;
        } else {
            parent::with($key, $value);
        }

        return $this;
    }
}
