<?php

namespace App\DataTables;

use App\CategoiresCourses;
use App\Courses;
use App\User;
use Yajra\DataTables\Services\DataTables;

class CoursesDatatable extends DataTables
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

            ->editColumn('action', 'backend.courses.action')

            ->editColumn('status', function ($query) {
                if ($query->status == 1) {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">فعال</span>';
                } else {
                    return '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">متوقف</span>';
                }
            })
            ->editColumn('category_id', function ($query) {
                $category = CategoiresCourses::find($query->category_id);
                return $category->name;
            })
            ->editColumn('user_id', function ($query) {
                $user = \App\User::find($query->user_id);
                if ($user) {
                    return $user->edit_link;
                }

                return '';
            })
            ->editColumn('lang', function ($query) {
                if ($query->lang == 'ar') {
                    return 'العربية';
                } else {
                    return 'الإنجليزية';
                }
            })
            ->rawColumns(['action', 'status', 'user_id'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Courses $model)
    {
        return $model->newQuery()->select('id', 'lang', 'name', 'user_id', 'category_id', 'price', 'status', 'created_at');
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
            'lang' => ['name' => 'lang', 'data' => 'lang', 'title' => __('pages.language')],
            'user_id' => ['name' => 'user_id', 'data' => 'user_id', 'title' => __('pages.author')],
            'name' => ['name' => 'name', 'data' => 'name', 'title' => __('pages.course-name')],
            'category_id' => ['name' => 'category_id', 'data' => 'category_id', 'title' => __('pages.category')],
            'price' => ['name' => 'price', 'data' => 'price', 'title' => __('pages.price')],
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
        return 'Courses_' . date('YmdHis');
    }
}