<?php

namespace App\DataTables;

use App\Testimonial;
use App\User;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class TestimonialDatatable extends DataTable
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
            ->editColumn('action', 'backend.testimonials.action')
            ->editColumn('datetime', function ($query) {
                return Carbon::parse($query->datetime)->format('Y-m-d');
            })
            ->editColumn('user_id', function ($query) {
                $user = User::find($query->user_id);
                return $user->f_name . ' ' . $user->l_name;
            })
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Testimonial $model)
    {
        return $model->newQuery()->select('id', 'user_id', 'message', 'datetime');
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
            'user_id' => ['name' => 'user_id', 'data' => 'user_id', 'title' => __('pages.user')],
            'message' => ['name' => 'message', 'data' => 'message', 'title' => __('pages.message')],
            'datetime' => ['name' => 'datetime', 'data' => 'datetime', 'title' => __('pages.created')],
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
        return 'Testimonials_' . date('YmdHis');
    }
}