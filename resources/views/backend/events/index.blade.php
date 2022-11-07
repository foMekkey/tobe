@extends('backend.layouts.app')

@section('style')
    <link href="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@endsection

@section('content')

    <div class="messages"></div>

    @include('errors.messages')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">

            <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-font-brand flaticon2-line-chart"></i>
					</span>
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.events') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <div class="dropdown dropdown-inline">

                            <button type="button" class="btn btn-bold btn-label-brand btn-sm" data-toggle="modal"
                                    data-target="#kt_modal_4"><i class="la la-plus"></i>{{ __('pages.add-new') }}
                            </button>

                        </div>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
        {!! $dataTable->table(['class' => 'table table-striped- table-bordered table-hover table-checkable','id'=>'event-tables', 'width' => '100%'],true) !!}
        <!--end: Datatable -->
        </div>
    </div>

<!--begin::Modal-->
<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('pages.event-name') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event') }}:</label>
                        <input type="text" class="form-control" id="event-name" name="name">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pages.close') }}</button>
                <button type="button" id="btnSubmitModal" class="btn btn-primary">{{ __('pages.save') }}</button>
            </div>
        </div>
    </div>
</div>

<!--end::Modal-->


<!--begin::Modal-->
<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{ __('pages.event-name') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="event_id" id="event_id" value=""/>

                    <label for="recipient-name" class="form-control-label">{{ __('pages.event') }}:</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pages.close') }}</button>
                <button type="button" id="btnEditModal" class="btn btn-primary">{{ __('pages.edit') }}</button>
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
        $(document).on('click', '.openModelEdit', function () {
            var id = $(this).data('value');
            var name = $(this).data('name');
            $('#name').val(name);
            $("#btnEditModal").on('click', function () {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var field1value = $('#name').val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('events/postupdate') }}" + '/' + id,
                    data: {'name': field1value},
                    dataType: "json",
                    success: function (msg) {
                        $('#kt_modal_1').modal('hide');
                        $('#event-tables').DataTable().ajax.reload();
                    }
                });
            });
        });

        $("#btnSubmitModal").on('click', function () {
            event.preventDefault();
            var field1value = $("#event-name").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('postaddevents') }}",
                data: {'name': field1value},
                dataType: "json",
                success: function (msg) {
                    console.log(msg);
                    $("#event-name").val('');
                    $('#kt_modal_4').modal('hide');
                    $('#event-tables').DataTable().ajax.reload();
                }
            });
        });
    </script>
@endsection
