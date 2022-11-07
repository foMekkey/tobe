@extends('backend.layouts.app')
@section('page-main-title', __('pages.consultations'))
@section('page-main-url', route('consultations') )


@section('style')
    <link href="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <style>
        .nav-pills, .nav-tabs {
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div class="message"></div>

    @include('errors.messages')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">

            <div class="kt-portlet__head-label">
                <ul id="myTab" class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('services') }}">
                            <h5>{{ __('pages.services') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">
                            <h5>{{ __('pages.blog') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site_setting') }}">
                            <h5>{{ __('pages.site_setting') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages') }}">
                            <h5>{{ __('pages.pages') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact_messages') }}">
                            <h5>{{ __('pages.contact_messages') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('testimonials') }}">
                            <h5>{{ __('pages.testimonials') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('newsletters') }}">
                            <h5>{{ __('pages.store-newsletter') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active">
                            <h5>{{ __('pages.consultations') }}</h5>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
             {!! $dataTable->table(['class' => 'table table-striped- table-bordered table-hover table-checkable', 'id' => 'consult_datatable', 'width' => '100%'],true) !!}
            <!--end: Datatable -->
        </div>
    </div>
    
    <!--begin::Modal-->
    <div class="modal fade" id="kt_modal_consult" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل حالة الإستشارة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="consult_form">
                    <div class="modal-body">
                        <div class="alert alert-danger" id="consult_error" style="display: none">الرجاء ملىء جميع الحقول</div>
                        <div class="form-group">
                            <label for="status" class="form-control-label">{{ __('pages.status-column') }}:</label>
                            <select class="form-control" name="status" id="status">
                                <option value=""></option>
                                <option value="1">إعتماد</option>
                                <option value="2">ارسال تعديل مقترح</option>
                            </select>
                        </div>
                        <div class="form-group" id="suggested_date" style="display: none">
                            <label for="status" class="form-control-label">التاريخ:</label>
                            <input type="text" class="form-control" id="datepickerr" name="suggested_date" readonly />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="consult_id" name="consult_id" value="" />
                        <input type="submit" class="btn btn-primary" value="{{ __('pages.save') }}" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pages.close') }}</button>
                    </div>
                </form>
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
        $.fn.datepicker.dates['ar'] = {
            days: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"],
            daysShort: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت", "أحد"],
            daysMin: ["ح", "ن", "ث", "ع", "خ", "ج", "س", "ح"],
            months: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
            monthsShort: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
            today: "هذا اليوم",
            rtl: true
        };
        $('#datepickerr').datepicker({
            language: 'ar',
            format: "yyyy-mm-dd",
        });
        
        $('#status').change(function() {
            if ($(this).val() == 2) {
                $('#suggested_date').show();
            } else {
                $('#suggested_date').hide();
            }
            $('#consult_error').hide();
        });
        
        $(document).on('click', '.reply_btn', function() {
            $('#consult_id').val($(this).data('rel'));
            $('#status').val('');
            $('#suggested_date').hide();
        });
        
        
        $("#consult_form").submit(function (event) {
            // Stop form from submitting normally
            event.preventDefault();

            if (!$('#status').val() || ($('#status').val() == '2' && !$('#datepickerr').val())) {
                $('#consult_error').show();
                return false;
            }

            $.ajax({
                type: "POST",
                url: "{{ url('consultations/reply') }}",
                data: {'_token': "{{ csrf_token() }}", 'id': $('#consult_id').val(), 'status': $('#status').val(), 'suggested_date': $('#datepickerr').val()},
                dataType: "json",
                success: function (msg) {
                    if (msg.success) {
                        $('#kt_modal_consult').modal('hide');
                        location.reload();
                    } else {
                        $('#consult_error').show();
                    }
                }
            });
        });
    </script>
@endsection
