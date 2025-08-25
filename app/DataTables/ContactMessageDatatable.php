<?php

namespace App\DataTables;

use App\ContactMessage;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Asset;

class ContactMessageDatatable extends DataTable
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
            ->editColumn('datetime', function ($query) {
                return Carbon::parse($query->datetime)->format('Y-m-d');
            })
            ->addColumn('action', function ($message) {
                $replyBtn = '<a href="javascript:void(0)" class="btn btn-sm btn-primary reply-message" data-id="' . $message->id . '" data-email="' . $message->email . '" data-name="' . $message->name . '">
                                <i class="fa fa-reply"></i> رد
                            </a>';

                $deleteBtn = '<a href="javascript:void(0)" class="btn btn-sm btn-danger delete-message" data-id="' . $message->id . '">
                                <i class="fa fa-trash"></i> حذف
                            </a>';

                return '<div class="btn-group" role="group">' . $replyBtn . ' ' . $deleteBtn . '</div>';
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ContactMessage $model)
    {
        return $model->newQuery()->select('id', 'name', 'email', 'message', 'datetime');
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
            ->addAction(['width' => '150px', 'printable' => false, 'title' => 'الإجراءات'])
            ->parameters([
                'dom'     => 'Blfrtip',
                'responsive' => true,
                'order'   => [[0, 'desc']],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'language' => ['url' => asset('ar-datatable.json')],
                'buttons' => [
                    ['extend' => 'excel', 'text' => '<i class="fa fa-download"></i>Excel', 'className' => 'dt-button buttons-copy buttons-html5 btn btn-default legitRipple'],
                    ['extend' => 'print', 'text' => '<i class="fa fa-print"></i>Print', 'className' => 'dt-button buttons-copy buttons-html5 btn btn-default legitRipple'],
                ]
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
            'email' => ['name' => 'email', 'data' => 'email', 'title' => __('pages.email')],
            'message' => ['name' => 'message', 'data' => 'message', 'title' => __('pages.message')],
            'datetime' => ['name' => 'datetime', 'data' => 'datetime', 'title' => __('pages.created')],
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
        return 'ContactMessages_' . date('YmdHis');
    }
}
