<?php

namespace App\DataTables;

use App\Subscription;
use App\User;
use App\Courses;

use Yajra\DataTables\Services\DataTable;

class SubscriptionsDataTable extends DataTable
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

            ->editColumn('action', 'backend.subscriptions.action')

            ->editColumn('payment_method', function ($query) {
                if ($query->payment_method == 0) {
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">' . __('pages.bank_transfer') . '</span>';
                } else {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">' . __('pages.e_wallet_transfer') . '</span>';
                }
            })
            ->editColumn('status', function ($query) {
                if ($query->status == 0) {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">' . __('pages.pending') . '</span>';
                } else if ($query->status == 1) {
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">' . __('pages.accepted') . '</span>';
                } else {
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">' . __('pages.rejected') . '</span>';
                }
            })
            ->editColumn('course_id', function ($query) {
                $course = Courses::find($query->course_id);
                return $course->name;
            })
            ->editColumn('user_id', function ($query) {
                $user = \App\User::find($query->user_id);
                if ($user) {
                    return $user->edit_link;
                }

                return '';
            })
            ->rawColumns(['action', 'user_id', 'course_id', 'payment_method', 'status'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Subscription $model)
    {
        return $model->newQuery()->select('id', 'user_id', 'course_id', 'payment_method', 'status', 'created_at');
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
                            window.location = '" . route('subscriptions.export') . "';
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
        $cols =  [
            'DT_RowIndex' => ['name' => 'id', 'data' => 'DT_RowIndex', 'title' => '#'],
            'user_id' => ['name' => 'user_id', 'data' => 'user_id', 'title' => __('pages.user')],
            'course_id' => ['name' => 'course_id', 'data' => 'course_id', 'title' => __('pages.course')],
            'payment_method' => ['name' => 'payment_method', 'data' => 'payment_method', 'title' => __('pages.payment_method')],
            'status' => ['name' => 'status', 'data' => 'status', 'title' => __('pages.status')],
            'created_at' => ['name' => 'created_at', 'data' => 'created_at', 'title' => __('pages.register_at')],
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
        return 'Subscriptions_' . date('YmdHis');
    }
}
