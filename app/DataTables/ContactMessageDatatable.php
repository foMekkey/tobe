<?php

namespace App\DataTables;

use App\ContactMessage;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

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
            ->editColumn('datetime',function($query){
                return Carbon::parse($query->datetime)->format('Y-m-d');
            })
            ->addIndexColumn();
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
            ->parameters([
                'dom'     => 'Blfrtip',
                'responsive' => true,
                'order'   => [[0, 'desc']],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'language' => ['url' => asset('ar-datatable.json')],
                'buttons' => []
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
            'name' => ['name' => 'name' ,'data' => 'name' , 'title' => __('pages.name')],
            'email' => ['name' => 'email' ,'data' => 'email' , 'title' => __('pages.email')],
            'message' => ['name' => 'message' ,'data' => 'message' , 'title' =>__('pages.message')],
            'datetime' => ['name' => 'datetime' ,'data' => 'datetime' , 'title' =>__('pages.created')],
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
