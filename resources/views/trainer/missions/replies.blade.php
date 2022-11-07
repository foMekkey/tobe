@extends('backend.layouts.app')
@section('page-main-title', __('pages.missions-replies'))
@section('page-main-url', "" )


@section('style')
    <link href="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <style>
        .fa-star, .fa-star-o {
            color: #FF7F00;
            margin-left: 2px;
        }
    </style>
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
                    {{ __('pages.missions-replies') }}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
             {!! $dataTable->table(['class' => 'table table-striped- table-bordered table-hover table-checkable', 'width' => '100%'],true) !!}
            <!--end: Datatable -->
        </div>
    </div>
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
@endsection
