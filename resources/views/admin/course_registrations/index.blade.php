@extends('backend.layouts.app')

@section('page-main-title', 'طلبات التسجيل في الدورات')

@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-line-chart"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    طلبات التسجيل في الدورات
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
            {!! $dataTable->table(
                ['class' => 'table table-striped- table-bordered table-hover table-checkable', 'width' => '100%'],
                true,
            ) !!}
            <!--end: Datatable -->
        </div>
    </div>

    <!-- Modal for Rejection Reason -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">رفض طلب التسجيل</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rejection_reason">سبب الرفض (اختياري)</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"></textarea>
                            <small class="form-text text-muted">سيتم إرسال هذا السبب إلى المتقدم.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js">
    </script>
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/datatables/advanced/column-rendering.js') }}"
        type="text/javascript"></script>

    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function() {
            // تعيين عنوان النموذج عند فتح نافذة الرفض
            $(document).on('click', '.reject-btn', function() {
                var registrationId = $(this).data('id');
                var rejectUrl = "{{ route('registrations.reject', ':id') }}".replace(':id',
                    registrationId);
                $('#rejectForm').attr('action', rejectUrl);
                $('#rejectModal').modal('show');
            });
        });
    </script>
@endsection
