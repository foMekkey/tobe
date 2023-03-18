<?php

namespace App\DataTables;

use App\Service;
use App\User;
use Yajra\DataTables\Services\DataTable;

class ServiceDatatable extends DataTable
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

            ->editColumn('action', 'backend.services.action')
            ->editColumn('lang', function ($query) {
                if ($query->lang == 'ar') {
                    return 'العربية';
                } else {
                    return 'الإنجليزية';
                }
            })
            ->rawColumns(['action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Service $model)
    {
        return $model->newQuery()->select('id', 'lang', 'title', 'desc');
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
            'DT_RowIndex' => ['name' => 'id', 'data' => 'DT_RowIndex', 'title' => '#'],
            'lang' => ['name' => 'lang', 'data' => 'lang', 'title' => __('pages.language')],
            'title' => ['name' => 'title', 'data' => 'title', 'title' => __('pages.title')],
            'desc' => ['name' => 'desc', 'data' => 'desc', 'title' => __('pages.desc')],
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
        return 'Services_' . date('YmdHis');
    }
}