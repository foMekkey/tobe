<?php

namespace App\DataTables;

use App\Groups;
use App\User;
use Yajra\DataTables\Services\DataTable;
use DB;
class StudentGroupsDataTable extends DataTable
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
            ->editColumn('action', 'students.groups.btn.action')
            ->rawColumns(['action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Groups $model)
    {
        return DB::table('groups')->join('group_members','groups.id','group_members.group_id')->where('group_members.student_id',auth()->id()
        )->select('groups.id','name', 'desc','status', 'groups.created_at')->distinct('groups.id')->get();
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
            'name' => ['name' => 'name' ,'data' => 'name' , 'title' => __('pages.name-group')],
            'desc' => ['name' => 'desc' ,'data' => 'desc' , 'title' => __('pages.desc')],
            
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
        return 'Groups_' . date('YmdHis');
    }
}
