<?php

namespace App\DataTables;

use App\Event;
use App\NotificationSetting;
use App\User;
use Yajra\DataTables\Services\DataTable;

class NotificationDatatable extends DataTable
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
            ->addColumn('action', 'backend.notification.action')
            ->editColumn('status', function ($query) {
                if ($query->status == 1) {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">نشط</span>';
                } else {
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">غير نشط</span>';
                }
            })

            ->editColumn('notifications_event_id', function ($query) {
                $event = Event::find($query->notifications_event_id);
                return $event['name'];
            })

            ->editColumn('notifier', function ($query) {

                if ($query->notifier == 1) {
                    return __('pages.related_user');
                } elseif ($query->notifier == 2) {
                    return __('pages.owner_site');
                } elseif ($query->notifier == 3) {
                    return __('pages.big-user');
                } elseif ($query->notifier == 4) {
                    return __('pages.branch-super');
                } elseif ($query->notifier == 5) {
                    return __('pages.trainer-courses');
                } else {
                    return __('pages.student-course');
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
    public function query(NotificationSetting $model)
    {
        return $model->newQuery()->select('id', 'name', 'notifications_event_id', 'notifier', 'status', 'created_at');
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
            'name' => ['name' => 'name', 'data' => 'name', 'title' => __('pages.name')],
            'notifications_event_id' => ['name' => 'notifications_event_id', 'notifications_event_id' => 'name', 'title' => __('pages.events')],
            'notifier' => ['name' => 'notifier', 'data' => 'notifier', 'title' => __('pages.reciver')],
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
        return 'Notification_' . date('YmdHis');
    }
}