<?php

namespace App\DataTables;

use App\Survey;
use App\User;
use Yajra\DataTables\Services\DataTable;

class SurveysDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)

            ->editColumn('action', 'backend.surveys.action')
            ->editColumn('is_day_star', function ($query) {
                if ($query->is_day_star == 1) {
                    return __('pages.day-star');
                } else {
                    return __('pages.survey');
                }
            })
            ->editColumn('show_results_in_course', function ($query) {
                if ($query->show_results_in_course == 1) {
                    return __('pages.yes');
                } else {
                    return __('pages.no');
                }
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Survey $model)
    {
        return $model->newQuery()->select('id', 'course_id', 'title', 'date', 'is_day_star', 'show_results_in_course')
            ->where('course_id', $this->course_id);
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
                    ['extend' => 'excel', 'text' => '<i class="fa fa-download"></i>Excel', 'className' => 'dt-button buttons-copy buttons-html5 btn btn-default legitRipple'],
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
        $cols =  [
            'DT_RowIndex' => ['name' => 'id', 'data' => 'DT_RowIndex', 'title' => '#'],
            'title' => ['name' => 'title', 'data' => 'title', 'title' => __('pages.title')],
            'date' => ['name' => 'date', 'data' => 'date', 'title' => __('pages.date')],
            'is_day_star' => ['name' => 'is_day_star', 'data' => 'is_day_star', 'title' => __('pages.Type')],
            'show_results_in_course' => ['name' => 'show_results_in_course', 'data' => 'show_results_in_course', 'title' => __('pages.show_results_in_course')],
            'action' => ['exportable' => false, 'printable'  => false, 'searchable' => false, 'orderable'  => false, 'title' => __('pages.action')]
        ];

        return $cols;
    }


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Surveys_' . date('YmdHis');
    }
}