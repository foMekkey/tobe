<?php

namespace App\DataTables;

use App\Models\Cohort;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\User;
use App\Community;

class CohortsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', function ($cohort) {
            $id = $cohort->id;
            $actionButtons = view('admin.cohorts.datatables_actions', compact('id'))->render();

            // التحقق مما إذا كان الفوج له مجتمع بالفعل
            $community = Community::where('type', 'cohort')
                ->where('reference_id', $cohort->id)
                ->first();

            if ($community) {
                // إذا كان له مجتمع، أضف زر التعديل
                $communityButton = '<button type="button" class="btn btn-sm btn-info edit-community-btn" data-id="' . $cohort->id . '" data-community-id="' . $community->id . '" data-toggle="modal" data-target="#editCommunityModal">
                    <i class="fa fa-edit"></i> تعديل المجتمع
                </button>';
            } else {
                // إذا لم يكن له مجتمع، أضف زر الإضافة
                $communityButton = '<button type="button" class="btn btn-sm btn-primary add-community-btn" data-id="' . $cohort->id . '" data-toggle="modal" data-target="#addCommunityModal">
                    <i class="fa fa-plus"></i> إضافة مجتمع
                </button>';
            }

            return $actionButtons . ' ' . $communityButton;
        })
            ->editColumn('status', function ($cohort) {
                return $cohort->status ? '<span class="kt-badge kt-badge--success kt-badge--inline">مفعل</span>' :
                    '<span class="kt-badge kt-badge--danger kt-badge--inline">غير مفعل</span>';
            })
            ->editColumn('start_date', function ($cohort) {
                return $cohort->start_date->format('Y-m-d');
            })
            ->editColumn('end_date', function ($cohort) {
                return $cohort->end_date->format('Y-m-d');
            })
            ->addColumn('trainees_count', function ($cohort) {
                return $cohort->registrationsCount() . ' / ' . $cohort->max_trainees;
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Cohort $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Cohort $model)
    {
        return $model->newQuery()->select('id', 'name', 'start_date', 'end_date', 'max_trainees', 'status', 'created_at')
            ->withCount('trainees');
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
            ->addAction(['width' => '120px', 'printable' => false, 'title' => 'الإجراءات'])
            ->parameters([
                'dom'     => 'Blfrtip',
                'responsive' => true,
                'order'   => [[0, 'desc']],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'buttons' => [
                    ['extend' => 'print', 'text' => '<i class="fa fa-print"></i>Print', 'className' => 'dt-button buttons-copy buttons-html5 btn btn-default legitRipple'],
                    ['text' => '<i class="fa fa-download"></i>Excel', 'className' => 'dt-button buttons-copy buttons-html5 btn btn-default legitRipple', 'action' => 'function(){window.location.href = "' . route('admin.cohorts.export') . '"}'],
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
            'id' => ['title' => '#', 'searchable' => false],
            'name' => ['title' => 'اسم الفوج'],
            'start_date' => ['title' => 'تاريخ البداية'],
            'end_date' => ['title' => 'تاريخ النهاية'],
            'trainees_count' => ['title' => 'عدد المتدربين', 'searchable' => false, 'orderable' => false],
            'status' => ['title' => 'الحالة'],
            'created_at' => ['title' => 'تاريخ الإنشاء', 'visible' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'cohorts_' . date('YmdHis');
    }
}