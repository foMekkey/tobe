@extends('backend.layouts.app')
@section('page-main-title', __('pages.contact_messages'))
@section('page-main-url', route('contact_messages'))


@section('style')
    <link href="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <style>
        .nav-pills,
        .nav-tabs {
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
                        <a class="nav-link active" href="{{ route('contact_messages') }}">
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
                        <a class="nav-link" href="{{ route('consultations') }}">
                            <h5>{{ __('pages.consultations') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faqs') }}">
                            <h5>{{ __('pages.faqs') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('e_wallets') }}">
                            <h5>{{ __('pages.e_wallets') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('banks') }}">
                            <h5>{{ __('pages.banks') }}</h5>
                        </a>
                    </li>
                </ul>
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

    <script type="text/javascript">
        $(document).ready(function() {

            // Delete message
            $(document).on('click', '.delete-message', function() {
                var messageId = $(this).data('id');

                if (confirm('هل أنت متأكد من حذف هذه الرسالة؟')) {
                    $.ajax({
                        url: '{{ url('contact-messages') }}/' + messageId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                // Refresh the DataTable - this will work with any DataTable on the page
                                $('.dataTable').DataTable().ajax.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function() {
                            toastr.error('حدث خطأ أثناء حذف الرسالة');
                        }
                    });
                }
            });

            // Reply to message
            $(document).on('click', '.reply-message', function() {
                var messageId = $(this).data('id');
                var email = $(this).data('email');
                var name = $(this).data('name');

                // Create modal for reply
                var modal = `
                <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="replyModalLabel">الرد على رسالة من: ${name} (${email})</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="replyForm">
                                    <input type="hidden" name="id" value="${messageId}">
                                    <div class="form-group">
                                        <label for="reply">نص الرد:</label>
                                        <textarea class="form-control" id="reply" name="reply" rows="6" required></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                <button type="button" class="btn btn-primary" id="sendReply">إرسال الرد</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                // Append modal to body and show it
                $('body').append(modal);
                $('#replyModal').modal('show');

                // Handle modal close (remove from DOM)
                $('#replyModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });

                // Handle send reply
                $('#sendReply').on('click', function() {
                    var reply = $('#reply').val();

                    if (!reply) {
                        toastr.error('يرجى كتابة نص الرد');
                        return;
                    }

                    $(this).prop('disabled', true).html(
                        '<i class="fa fa-spinner fa-spin"></i> جاري الإرسال...');

                    $.ajax({
                        url: '{{ route('contact_messages.reply') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: messageId,
                            reply: reply
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $('#replyModal').modal('hide');
                            } else {
                                toastr.error(response.message ||
                                    'حدث خطأ أثناء إرسال الرد');
                                $('#sendReply').prop('disabled', false).text(
                                    'إرسال الرد');
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON ? xhr.responseJSON.errors :
                                null;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                            } else {
                                toastr.error('حدث خطأ أثناء إرسال الرد');
                            }
                            $('#sendReply').prop('disabled', false).text('إرسال الرد');
                        }
                    });
                });
            });
        });
    </script>
@endsection
