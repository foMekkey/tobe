<?php

namespace App\DataTables;

use App\CategoiresCourses;
use App\Courses;
use App\User;
use App\Community;
use Yajra\DataTables\Services\DataTable;

class CoursesDatatable extends DataTable
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
            ->editColumn('action', function ($query) {
                $id = $query->id;
                $actionButtons = view('backend.courses.action', compact('id'))->render();

                // التحقق مما إذا كان الكورس له مجتمع بالفعل
                $community = Community::where('type', 'course')
                    ->where('reference_id', $query->id)
                    ->first();

                if ($community) {
                    // إذا كان له مجتمع، أضف زر التعديل
                    $communityButton = '<button type="button" class="btn btn-sm btn-info edit-community-btn" data-id="' . $query->id . '" data-community-id="' . $community->id . '" data-toggle="modal" data-target="#editCommunityModal">
                        <i class="fa fa-edit"></i> تعديل المجتمع
                    </button>';
                } else {
                    // إذا لم يكن له مجتمع، أضف زر الإضافة
                    $communityButton = '<button type="button" class="btn btn-sm btn-primary add-community-btn" data-id="' . $query->id . '" data-toggle="modal" data-target="#addCommunityModal">
                        <i class="fa fa-plus"></i> إضافة مجتمع
                    </button>';
                }

                return $actionButtons . ' ' . $communityButton;
            })
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
            ->rawColumns(['action', 'status', 'user_id'])
            ->setRowId('id')
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
                    [
                        'text' => '<i class="fa fa-download"></i>Excel',
                        'className' => 'dt-button buttons-excel buttons-html5 btn btn-default legitRipple',
                        'action' => "function ( e, dt, node, config ) {
                            window.location = '" . route('courses.export') . "';
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