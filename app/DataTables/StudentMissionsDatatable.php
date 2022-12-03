<?php

namespace App\DataTables;

use App\Mission;
use App\User;
use Yajra\DataTables\Services\DataTable;

class StudentMissionsDatatable extends DataTable
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

            ->editColumn('action', 'students.missions.action')
            ->editColumn('user_id', function ($query) {
                $user = User::find($query->user_id);

                return $user->user_name ?? '';
            })
            ->addColumn('status', function ($query) {
                return $query->getStatus();
            })
            ->addColumn('trainer_rate', function ($query) {
                $reply = \App\MissionReply::where('user_id', auth()->user()->id)->where('mission_id', $query->id)->first();
                if ($reply && $reply->trainer_rate) {
                    $output = '';
                    for ($i = 1; $i < 6; $i++) {
                        if ($i <= $reply->trainer_rate) {
                            $output .= '<span class="fa fa-star"></span>';
                        } else {
                            $output .= '<span class="fa fa-star-o"></span>';
                        }
                    }

                    return $output;
                }

                return '';
            })
            ->rawColumns(['action', 'status', 'trainer_rate'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Mission $model)
    {
        $userGroups = \App\GroupMember::where('student_id', auth()->user()->id)->pluck('group_id')->toArray();

        if ((int)count($userGroups) === 0)
            return [];
        return $model->newQuery()->select('id', 'name', 'user_id', 'period', 'expire_date')->where(function ($q) use ($userGroups) {
            $q->where(function ($q1) {
                $q1->where('mission_to', '1');
                $q1->where('mission_to_id', auth()->user()->id);
            });
            $q->orWhere(function ($q2) use ($userGroups) {
                $q2->where('mission_to', '2');
                $q2->orWhereIn('mission_to_id', $userGroups);
            });
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
            'user_id' => ['name' => 'user_id', 'data' => 'user_id', 'title' => __('pages.instructor_name')],
            'name' => ['name' => 'name', 'data' => 'name', 'title' => __('pages.mission-title')],
            'period' => ['name' => 'period', 'data' => 'period', 'title' => __('pages.period')],
            'expire_date' => ['name' => 'expire_date', 'data' => 'expire_date', 'title' => __('pages.expire_date')],
            'status' => ['name' => 'status', 'data' => 'status', 'title' => __('pages.status-column')],
            'trainer_rate' => ['name' => 'trainer_rate', 'data' => 'trainer_rate', 'title' => __('pages.trainer_rate')],
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
        return 'StudentMissions_' . date('YmdHis');
    }
}