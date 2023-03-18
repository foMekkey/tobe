<?php

namespace App\DataTables;

use App\MissionReply;
use App\User;
use Yajra\DataTables\Services\DataTable;

class TrainerMissionsRepliesDatatable extends DataTable
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

            ->editColumn('action', 'trainer.missions.action_replies')
            ->editColumn('status', function ($query) {
                if ($query->status == 1) {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">ينتظر المراجعة</span>';
                } else {
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">تم الإنجاز</span>';
                }
            })
            ->editColumn('user_id', function ($query) {
                $user = User::find($query->user_id);

                return $user->user_name ?? '';
            })
            ->editColumn('sent_at', function ($query) {
                return \Carbon\Carbon::parse($query->sent_at)->format('Y/m/d h:i a');
            })
            ->editColumn('trainer_rate', function ($query) {
                $output = '';
                for ($i = 1; $i < 6; $i++) {
                    if ($i <= $query->trainer_rate) {
                        $output .= '<span class="fa fa-star"></span>';
                    } else {
                        $output .= '<span class="fa fa-star-o"></span>';
                    }
                }
                return $output;
            })
            ->rawColumns(['action', 'status', 'trainer_rate'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MissionReply $model)
    {
        return $model->newQuery()->select('id', 'user_id', 'trainer_rate', 'status', 'sent_at')->where('mission_id', $this->id);
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
            'user_id' => ['name' => 'user_id', 'data' => 'user_id', 'title' => __('pages.Student')],
            'sent_at' => ['name' => 'sent_at', 'data' => 'sent_at', 'title' => __('pages.sent_at')],
            'status' => ['name' => 'status', 'data' => 'status', 'title' => __('pages.status-column')],
            'trainer_rate' => ['name' => 'trainer_rate', 'data' => 'trainer_rate', 'title' => __('pages.trainer_rate')],
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
        return 'TrainerMissionsReplies_' . date('YmdHis');
    }
}