@extends('backend.layouts.app')
@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <style>
        .bootstrap-tagsinput {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            display: block;
            padding: 4px 6px;
            color: #555;
            vertical-align: middle;
            border-radius: 4px;
            max-width: 100%;
            line-height: 22px;
            cursor: text;
        }

        .bootstrap-tagsinput input {
            border: none;
            box-shadow: none;
            outline: none;
            background-color: transparent;
            padding: 0 6px;
            margin: 0;
            width: auto;
            max-width: inherit;
        }

        .label-info {
            background-color: #5bc0de;
            padding: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="kt-wizard-v4" id="kt_apps_user_add_user" data-ktwizard-state="step-first">

        @include('errors.messages')
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        تفاصيل الفوج: {{ $cohort->name }}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{ route('cohorts.edit', $cohort->id) }}"
                                class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-edit"></i>
                                تعديل
                            </a>
                            <a href="{{ route('cohorts.index') }}" class="btn btn-secondary btn-elevate btn-icon-sm">
                                <i class="la la-arrow-left"></i>
                                رجوع
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-section">
                            <h4 class="kt-section__title">معلومات الفوج:</h4>
                            <div class="kt-section__content">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 40%">الاسم</th>
                                            <td>{{ $cohort->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>الوصف</th>
                                            <td>{{ $cohort->description ?? 'لا يوجد' }}</td>
                                        </tr>
                                        <tr>
                                            <th>تاريخ البداية</th>
                                            <td>{{ $cohort->start_date->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <th>تاريخ النهاية</th>
                                            <td>{{ $cohort->end_date->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <th>المدة</th>
                                            <td>{{ $cohort->start_date->diffInMonths($cohort->end_date) }} شهر</td>
                                        </tr>
                                        <tr>
                                            <th>الحد الأقصى للمتدربين</th>
                                            <td>{{ $cohort->max_trainees }}</td>
                                        </tr>
                                        <tr>
                                            <th>عدد المتدربين الحالي</th>
                                            <td>{{ $cohort->registrationsCount() }}</td>
                                        </tr>
                                        <tr>
                                            <th>الحالة</th>
                                            <td>
                                                @if ($cohort->status)
                                                    <span class="kt-badge kt-badge--success kt-badge--inline">مفعل</span>
                                                @else
                                                    <span class="kt-badge kt-badge--danger kt-badge--inline">غير مفعل</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>تاريخ الإنشاء</th>
                                            <td>{{ $cohort->created_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-section">
                            <h4 class="kt-section__title">إضافة متدرب للفوج:</h4>
                            <div class="kt-section__content">
                                @if ($cohort->hasAvailableSlots())
                                    {!! Form::open(['route' => ['cohorts.addTrainee', $cohort->id], 'method' => 'post', 'class' => 'kt-form']) !!}
                                    <div class="form-group">
                                        <label for="user_id">اختر المتدرب:</label>
                                        <select name="user_id" id="user_id" class="form-control select2" required>
                                            <option value="">-- اختر متدرب --</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">إضافة المتدرب</button>
                                    </div>
                                    {!! Form::close() !!}
                                @else
                                    <div class="alert alert-warning">
                                        <strong>تنبيه!</strong> لقد وصل الفوج إلى الحد الأقصى من المتدربين
                                        ({{ $cohort->max_trainees }}).
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

                <div class="kt-section">
                    <h4 class="kt-section__title">المتدربين في الفوج:</h4>
                    <div class="kt-section__content">
                        <!--begin: Datatable -->
                        {!! $dataTable->table(
                            ['class' => 'table table-striped- table-bordered table-hover table-checkable', 'width' => '100%'],
                            true,
                        ) !!}
                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    <!--begin::Page Vendors(used by this page) -->
    <script src="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js">
    </script>
    <!--end::Page Vendors -->
    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/datatables/advanced/column-rendering.js') }}"
        type="text/javascript"></script>
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function() {
            // Initialize select2
            $('.select2').select2({
                placeholder: "اختر متدرب",
                allowClear: true,
                ajax: {
                    url: "{{ route('cohorts.getAvailableTrainees', $cohort->id) }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.user_name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
