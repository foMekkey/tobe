<?php

namespace App\DataTables;

use App\Meeting;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class TrainerMeetingDatatable extends DataTable
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

            ->editColumn('action', 'trainer.meeting.action')
            ->editColumn('date', function ($query) {
                return Carbon::parse($query->date)->format('Y-m-d');
            })
            ->setRowId('id')
            ->rawColumns(['action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Meeting $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Meeting $model)
    {
        return $model->newQuery()->select('id', 'name', 'date', 'time', 'period', 'created_at')->where('user_id', auth()->user()->id);
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
            'name' => ['name' => 'name', 'data' => 'name', 'title' => __('pages.name-meet')],
            'date' => ['name' => 'date', 'data' => 'date', 'title' => __('pages.data-start')],
            'time' => ['name' => 'time', 'data' => 'time', 'title' => __('pages.time')],
            'period' => ['name' => 'period', 'data' => 'period', 'title' => __('pages.period')],
            //  'created_at' => ['name' => 'created_at' ,'data' => 'created_at' , 'title' => __('pages.created_at')],
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
        return 'TrainerMeeting_' . date('YmdHis');
    }
}