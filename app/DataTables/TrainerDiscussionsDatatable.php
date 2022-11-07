<?php

namespace App\DataTables;

use App\Discussion;
use App\Courses;
use Yajra\DataTables\Services\DataTable;

class TrainerDiscussionsDatatable extends DataTable
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

            ->editColumn('action', 'trainer.discussions.action')


            ->editColumn('course_id',function($query){
                if ($query->course_id) {
                    $category = Courses::find($query->course_id);
                    return $category->name ?? '';
                }
                
                return '';
            })
            ->rawColumns(['action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Discussion $model)
    {
        return $model->newQuery()->select( 'id', 'user_id','title','course_id','created_at', 'updated_at')->where(function($q) {
            $q->where('user_id',auth()->user()->id);
            $q->orWhereNull('course_id');
        });
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
        return [
            'DT_RowIndex' => ['name' => 'id' ,'data' => 'DT_RowIndex' ,'title' => '#'],
            'title'       => ['name' => 'title' ,'data' => 'title' ,'title' =>__('pages.discussions-title')],
            'course_id'   => ['name' => 'course_id' ,'data' => 'course_id' ,'title' =>__('pages.course-name')],
            'created_at' => ['name' => 'created_at' ,'data' => 'created_at' , 'title' => __('pages.register_at')],
            'action' => [ 'exportable' => false, 'printable'  => false, 'searchable' => false, 'orderable'  => false, 'title' => __('pages.action')]

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TrainerDiscussions_' . date('YmdHis');
    }
}
