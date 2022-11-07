@extends('backend.layouts.app')

@section('style')
    <link href="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">

@endsection

@section('content')

    <div class="message"></div>

    @include('errors.messages')


    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">

            <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-font-brand flaticon2-line-chart"></i>
					</span>
                <h3 class="kt-portlet__head-title">
                    المستخدمين
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <div class="dropdown dropdown-inline">

                            <a href="{{route('addusers')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                اضافة جديد
                            </a>

                        </div>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
             {!! $dataTable->table(['class' => 'table table-striped- table-bordered table-hover table-checkable', 'width' => '100%'],true) !!}
            <!--end: Datatable -->
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="AddEventModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('pages.add-event') }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" style="display: none" id="add-alert">
                        الرجاء ملىء جميع الحقول
                    </div>
                    
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event-name') }}:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event_start') }}:</label>
                        <input type="date" class="form-control" name="start_date" id="start_date">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event_end') }}:</label>
                        <input type="date" class="form-control" name="end_date" id="end_date">
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="user_id" name="user_id" value="" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pages.close') }}</button>
                    <button type="button" id="appointment_save" class="btn btn-primary">{{ __('pages.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection


@section('script')

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>

    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>

    <!--begin::Page Vendors(used by this page) -->
    <script src="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <!--end::Page Vendors -->
    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/datatables/advanced/column-rendering.js') }}" type="text/javascript"></script>

    {!! $dataTable->scripts() !!}

    <script>
        $(document).on('click', '.add_event', function() {
            $('#user_id').val($(this).data('rel'));
            $('#name').val('');
            $('#start_date').val('');
            $('#end_date').val('');
        });
        
        $("#appointment_save").on('click', function () {
            event.preventDefault();
            var user_id = $("#user_id").val();
            var field1value = $("#name").val();
            var field1start = $("#start_date").val();
            var field1end = $("#end_date").val();
            if (!user_id || !field1value || !field1start || !field1end) {
                $('#add-alert').show();
                return false;
            } else {
                $('#add-alert').hide();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ url('events/store_for_student') }}",
                    data: {'user_id': user_id, 'name': field1value,'start_date':field1start,'end_date':field1end},
                    dataType: "json",
                    success: function (msg) {
                        $('#AddModel').modal('hide');
                        location.reload();
                    }
                });
            }
        });
    </script>
@endsection
