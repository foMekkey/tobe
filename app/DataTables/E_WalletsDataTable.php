<?php

namespace App\DataTables;

use App\E_Wallet;
use Yajra\DataTables\Services\DataTable;

class E_WalletsDatatable extends DataTable
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

            ->editColumn('action', 'backend.e_wallets.action') // 

            ->editColumn('status',function($query){
               if($query->status == 1)
                {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">فعال</span>';
                }else{
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">متوقف</span>';

                }
            })
            
            ->rawColumns(['action', 'status'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\E_Wallet $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(E_Wallet $model)
    {
            return $model->newQuery()->select('id', 'number', 'company_name_ar', 'company_name_en', 'active', 'created_at');
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
                    ['extend' => 'excel', 'text' => '<i class="fa fa-download"></i>Excel' , 'className' =>'dt-button buttons-copy buttons-html5 btn btn-default legitRipple'],
                    ['extend' => 'print' , 'text' => '<i class="fa fa-print"></i>Print' , 'className' =>'dt-button buttons-copy buttons-html5 btn btn-default legitRipple'],

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
            'DT_RowIndex' => ['name' => 'id' ,'data' => 'DT_RowIndex' ,'title' => '#'],
            'number' => ['name' => 'number' ,'data' => 'number' , 'title' => __('pages.wallet_number')],
            'company_name_ar' => ['name' => 'company_name_ar' ,'data' => 'company_name_ar' , 'title' => __('pages.company_name_ar')],
            'company_name_en' => ['name' => 'company_name_en' ,'data' => 'company_name_en' , 'title' => __('pages.company_name_en')],
            'active' => ['name' => 'active' ,'data' => 'active' , 'title' => __('pages.status')],
            'created_at' => ['name' => 'created_at' ,'data' => 'created_at' , 'title' => __('pages.register_at')],
            'action' => [ 'exportable' => false, 'printable'  => false, 'searchable' => false, 'orderable'  => false, 'title' => __('pages.action')]
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
        return 'E_Wallets_' . date('YmdHis');
    }
}
