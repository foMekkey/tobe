@extends('backend.layouts.app')
@section('page-main-title', __('pages.courses'))
@section('page-main-url', route('courses'))


@section('style')
    <link href="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">

@endsection

@section('content')

    <div class="message">

    </div>

    @include('errors.messages')


    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">

            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-line-chart"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.courses') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <div class="dropdown dropdown-inline">

                            <a href="{{ route('addcourses') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                {{ __('pages.add-new') }}
                            </a>

                        </div>
                        &nbsp;
                    </div>
                </div>
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
        <!-- مودال إضافة مجتمع -->
        <div class="modal fade" id="addCommunityModal" tabindex="-1" role="dialog"
            aria-labelledby="addCommunityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCommunityModalLabel">إضافة مجتمع للكورس</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addCommunityForm" method="POST" action="{{ route('community.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="type" value="course">
                            <input type="hidden" name="reference_id" id="course_id">

                            <div class="form-group">
                                <label for="name">اسم المجتمع</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="description">وصف المجتمع</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="cover_image">صورة الغلاف</label>
                                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                        value="1" checked>
                                    <label class="custom-control-label" for="is_active">مفعل</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- مودال تعديل مجتمع -->
        <div class="modal fade" id="editCommunityModal" tabindex="-1" role="dialog"
            aria-labelledby="editCommunityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCommunityModalLabel">تعديل مجتمع الكورس</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editCommunityForm" method="POST" action="{{ route('community.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="community_id" id="edit_community_id">

                            <div class="form-group">
                                <label for="edit_name">اسم المجتمع</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_description">وصف المجتمع</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="edit_cover_image">صورة الغلاف</label>
                                <input type="file" class="form-control-file" id="edit_cover_image"
                                    name="cover_image">
                                <small class="form-text text-muted">اترك هذا الحقل فارغًا إذا كنت لا ترغب في تغيير الصورة
                                    الحالية.</small>
                                <div id="current_image_container" class="mt-2"></div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="edit_is_active"
                                        name="is_active" value="1">
                                    <label class="custom-control-label" for="edit_is_active">مفعل</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
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

    <script type="text/javascript">
        $(document).ready(function() {
            // عند النقر على زر إضافة مجتمع
            $(document).on('click', '.add-community-btn', function() {
                var courseId = $(this).data('id');
                $('#course_id').val(courseId);
            });

            // عند النقر على زر تعديل مجتمع
            $(document).on('click', '.edit-community-btn', function() {
                var courseId = $(this).data('id');
                var communityId = $(this).data('community-id');

                // جلب بيانات المجتمع عبر AJAX
                $.ajax({
                    url: '/community/' + communityId + '/edit',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#edit_community_id').val(communityId);
                        $('#edit_name').val(data.name);
                        $('#edit_description').val(data.description);
                        $('#edit_is_active').prop('checked', data.is_active == 1);

                        // عرض الصورة الحالية إذا كانت موجودة
                        if (data.cover_image) {
                            $('#current_image_container').html('<img src="' +
                                '{{ asset(config('filesystems.disks.contabo.url')) }}' +
                                '/' + data.cover_image +
                                '" class="img-thumbnail" style="max-height: 150px;">');
                        } else {
                            $('#current_image_container').empty();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('حدث خطأ أثناء جلب بيانات المجتمع');
                    }
                });
            });
        });
    </script>
@endsection
