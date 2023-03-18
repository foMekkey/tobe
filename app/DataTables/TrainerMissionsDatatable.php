<?php

namespace App\DataTables;

use App\Mission;
use App\User;
use Yajra\DataTables\Services\DataTable;

class TrainerMissionsDatatable extends DataTable
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

            ->editColumn('action', 'trainer.missions.action')

            ->editColumn('mission_to', function ($query) {
                if ($query->mission_to == 1) {
                    return __('pages.Student');
                } else {
                    return __('pages.group');
                }
            })
            ->editColumn('mission_to_id', function ($query) {
                if ($query->mission_to == 1) {
                    $user = User::find($query->mission_to_id);

                    return $user->user_name ?? '';
                } else {
                    $group = \App\Groups::find($query->mission_to_id);

                    return $group->name ?? '';
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
    public function query(Mission $model)
    {
        return $model->newQuery()->select('id', 'name', 'mission_to', 'mission_to_id', 'period', 'expire_date')->where('user_id', auth()->user()->id);
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
            'name' => ['name' => 'name', 'data' => 'name', 'title' => __('pages.title')],
            'mission_to' => ['name' => 'mission_to', 'data' => 'mission_to', 'title' => __('pages.send-to')],
            'mission_to_id' => ['name' => 'mission_to_id', 'data' => 'mission_to_id', 'title' => __('pages.name')],
            'period' => ['name' => 'period', 'data' => 'period', 'title' => __('pages.period')],
            'expire_date' => ['name' => 'expire_date', 'data' => 'expire_date', 'title' => __('pages.expire_date')],
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
        return 'TrainerMissions_' . date('YmdHis');
    }
}