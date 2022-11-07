<?php

namespace App\DataTables;

use App\Consultation;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class ConsultationDatatable extends DataTable
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
            ->editColumn('session_type',function($query){
                if ($query->session_type == 1) {
                    return __('pages.direct');
                }
                
                return __('pages.remotely');
            })
            ->editColumn('user_id',function($query){
                $user = \App\User::find($query->user_id);
                if ($user) {
                   return $user->edit_link;
                }
                
                return '';
            })
            ->editColumn('status',function($query){
                if ($query->status === 0) {
                    return '<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">ينتظر الرد</span>
                        <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md reply_btn" data-toggle="modal"
                                data-target="#kt_modal_consult" data-rel="' . $query->id . '"><i class="la la-reply"></i>
                        </button>';
                } elseif ($query->status == 1) {
                    return '<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill" style="background: #1dc9b7;">معتمد</span>';
                } elseif ($query->status == 2) {
                    return '<span class="kt-badge  kt-badge--unified-info kt-badge--inline kt-badge--pill">تعديل مقترح</span>';
                } elseif ($query->status == 3) {
                    return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">تعديل مرفوض</span>';
                }
            })
            ->rawColumns(['status'])
            ->escapeColumns([])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Consultation $model)
    {
        return $model->newQuery()->select('id', 'user_id', 'date', 'hours', 'session_type', 'subject', 'created_at', 'status');
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
            'user_id' => ['name' => 'user_id' ,'data' => 'user_id' , 'title' => __('pages.user')],
            'date' => ['name' => 'date' ,'data' => 'date' , 'title' => __('pages.date')],
            'hours' => ['name' => 'hours' ,'data' => 'hours' , 'title' => __('pages.hours')],
            'session_type' => ['name' => 'session_type' ,'data' => 'session_type' , 'title' =>__('pages.session_type')],
            'subject' => ['name' => 'subject' ,'data' => 'subject' , 'title' =>__('pages.subject')],
            'created_at' => ['name' => 'created_at' ,'data' => 'created_at' , 'title' =>__('pages.created_at')],
            'status' => ['name' => 'status' ,'data' => 'status' , 'title' =>__('pages.status-column')],
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
        return 'Consultations_' . date('YmdHis');
    }
}
