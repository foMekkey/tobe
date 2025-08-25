<?php

namespace App\DataTables;

use App\Bank;
use Yajra\DataTables\Services\DataTable;

class BanksDataTable  extends DataTable
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

            ->editColumn('action', 'backend.banks.action') // 

            ->editColumn('status', function ($query) {
                if ($query->status == 1) {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">فعال</span>';
                } else {
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">متوقف</span>';
                }
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\BanksDataTable  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bank $model)
    {
        return $model->newQuery()->select('id', 'bank_name_ar', 'bank_name_en', 'acc_name_ar', 'acc_name_en', 'acc_num', 'iban', 'active', 'created_at');
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
                        'extend' => 'collection',
                        'text' => '<i class="fa fa-download"></i>Excel',
                        'className' => 'dt-button buttons-copy buttons-html5 btn btn-default legitRipple',
                        'action' => "function ( e, dt, node, config ) {
                            window.location = '" . route('banks.export') . "';
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
            'bank_name_ar' => ['name' => 'bank_name_ar', 'data' => 'bank_name_ar', 'title' => __('pages.bank_name_ar')],
            'bank_name_en' => ['name' => 'bank_name_en', 'data' => 'bank_name_en', 'title' => __('pages.bank_name_en')],
            'acc_name_ar' => ['name' => 'acc_name_ar', 'data' => 'acc_name_ar', 'title' => __('pages.acc_name_ar')],
            'acc_name_en' => ['name' => 'acc_name_en', 'data' => 'acc_name_en', 'title' => __('pages.acc_name_en')],
            'acc_num' => ['name' => 'acc_num', 'data' => 'acc_num', 'title' => __('pages.acc_num')],
            'iban' => ['name' => 'iban', 'data' => 'iban', 'title' => __('pages.iban')],
            'active' => ['name' => 'status', 'data' => 'active', 'title' => __('pages.status')],
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
        return 'Banks_' . date('YmdHis');
    }
}
