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

        .note {
            width: 500px;
            margin: 50px auto;
            font-size: 1.1em;
            color: #333;
            text-align: justify;
        }

        #drop-area {
            border: 2px dashed #ccc;
            border-radius: 20px;
            width: 100%;
            margin: 50px auto;
            padding: 20px;
        }

        #drop-area.highlight {
            border-color: purple;
        }

        p {
            margin-top: 0;
        }

        .my-form {
            margin-bottom: 10px;
        }

        #gallery {
            margin-top: 10px;
        }

        #gallery img {
            width: 150px;
            margin-bottom: 10px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .button {
            display: inline-block;
            padding: 10px;
            background: #ccc;
            cursor: pointer;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .button:hover {
            background: #ddd;
        }

        #fileElem {
            display: none;
        }
    </style>
@endsection
@section('content')
    @include('errors.messages')
    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul id="myTab"
                    class="nav nav-tabs nav-tabs-space-xl nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand"
                    role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_user_edit_tab_1" role="tab">
                            <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon id="Bound" points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                        id="Shape" fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                        id="Path" fill="#000000" opacity="0.3" />
                                </g>
                            </svg> {{ __('pages.data') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_apps_user_edit_tab_2" role="tab">
                            <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                        id="Mask" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path
                                        d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                        id="Mask-Copy" fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg> {{ __('pages.users') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_apps_user_edit_tab_3" role="tab">
                            <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                        id="Path-50" fill="#000000" opacity="0.3" />
                                    <path
                                        d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
                                        id="Mask" fill="#000000" opacity="0.3" />
                                    <path
                                        d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
                                        id="Mask-Copy" fill="#000000" opacity="0.3" />
                                </g>
                            </svg> {{ __('pages.courses') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_apps_user_edit_tab_4" role="tab">
                            <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z"
                                        id="Combined-Shape" fill="#000000" opacity="0.3" />
                                    <path
                                        d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z"
                                        id="Combined-Shape" fill="#000000" />
                                </g>
                            </svg> {{ __('pages.files') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">



            <div class="tab-content">
                <div class="tab-pane active" id="kt_apps_user_edit_tab_1" role="tabpanel">
                    <div class="kt-form kt-form--label-right">
                        <form action="{{ route('postupdategroups', ['id' => $groups->id]) }}" id="kt_form_1"
                            method="post">
                            @csrf
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.name-group') }}
                                                <span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input class="form-control" name="name" type="text"
                                                    value="{{ $groups->name ? $groups->name : old('name') }}">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.Trainer') }}
                                                <span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-9">


                                                {{ Form::select('trainer_id', $trainers, $groups->trainer_id, ['class' => 'form-control', 'placeholder' => __('pages.choose-trainer')]) }}

                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.desc') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-9">
                                                <textarea class="form-control" name="desc" id="exampleTextarea" rows="3" spellcheck="false">{{ $groups->desc ? $groups->desc : old('desc') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label
                                                class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.group-key') }}</label>
                                            <div class="col-lg-9 col-xl-9">

                                                <input class="form-control" name="key" type="text" readonly
                                                    value="{{ $groups->key ? $groups->key : old('key') }}">
                                            </div>
                                        </div>





                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.tag') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input type="text" name="tags" class="form-control"
                                                    value="{{ $groups->tags }}" data-role="tagsinput" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">{{ __('pages.status') }}</label>
                                            <div class="col-9">
                                                <div class="kt-checkbox-single">
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox" name="status" value="1"
                                                            @if ($groups->status == 1) checked @endif>
                                                        <span></span>
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="kt-form__actions">

                                    <button
                                        class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                        type="submit">
                                        حفظ
                                    </button>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="kt_apps_user_edit_tab_2" role="tabpanel">
                    <div class="kt-form kt-form--label-right">
                        <div class="kt-form__body">
                            <table class="table table-striped- table-bordered table-hover table-checkable"
                                id="userGroups">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="kt_apps_user_edit_tab_3" role="tabpanel">
                    <div class="kt-form kt-form--label-right">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="courseGroups">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>name</th>
                                    <th>category</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="kt_apps_user_edit_tab_4" role="tabpanel">
                    <div class="kt-form kt-form--label-right">
                        <div class="kt-form__body">
                            <div class="form-group row">

                                <form method="post"
                                    action="{{ route('postaddgroupsfile', ['group_id' => $groups->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div id="drop-area">

                                        <div id="data">

                                            <i class="flaticon-upload"></i>
                                            <p>{{ __('pages.choose-to-upolad') }}</p>

                                            <input type="file" name="FileUploaded" id="fileElem" multiple
                                                onchange="handleFiles(this.files)">
                                            <label class="button" for="fileElem">{{ __('pages.choose-file') }}</label>

                                            <progress id="progress-bar" max=100 value=0></progress>
                                            <div id="gallery" />
                                        </div>
                                    </div>


                                    <button
                                        class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                        type="submit">
                                        {{ __('pages.upload') }}
                                    </button>
                                </form>



                            </div>

                        </div>
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="userFiles">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>name</th>
                                    <th>type</th>
                                    <th>size</th>
                                    <th>is_active</th>
                                    <th>created_at</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form>

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.name-file') }} <span
                                style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control" name="FileUploaded" id="file" required type="file">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('pages.close') }}</button>
                    <button type="button" id="btnSubmitModal"
                        class="btn btn-primary">{{ __('pages.save') }}</button>
                </div>

        </div>
    </div>
</div>


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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });


        // $("input").tagsinput('items');
    </script>


    <script>
        var groups = '{{ $groups->id }}';
        @if (checkPermission('DatatableUsersGroups'))
            $(function() {
                $('#userGroups').DataTable({
                    processing: true,
                    searching: true,
                    serverSide: true,
                    ajax: '{!! url('groups/datatable-users/') !!}' + '/' + groups,
                    "language": {
                        "url": "{{ asset('ar-datatable.json') }}"
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'title': '#'
                        },
                        {
                            data: 'user_name',
                            name: 'user_name',
                            'title': 'الاسم'
                        },
                        {
                            data: 'type',
                            name: 'type',
                            'title': 'الدور'
                        },
                        {
                            data: 'options',
                            name: 'options',
                            'title': 'العمليات'
                        },
                    ],
                });
            });
        @else
            $(function() {
                $('#userGroups').DataTable({
                    processing: true,
                    searching: true,
                    // serverSide: true,
                    {{-- ajax: '{!! url('groups/datatable-users/') !!}' + '/' + groups, --}} "language": {
                        "url": "{{ asset('ar-datatable.json') }}"
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'title': '#'
                        },
                        {
                            data: 'user_name',
                            name: 'user_name',
                            'title': 'الاسم'
                        },
                        {
                            data: 'type',
                            name: 'type',
                            'title': 'الدور'
                        },
                        {
                            data: 'options',
                            name: 'options',
                            'title': 'العمليات'
                        },
                    ],
                });
            });
        @endif
    </script>



    <script>
        var groups = '{{ $groups->id }}';

        @if (checkPermission('DatatableCoursesGroups'))

            $(function() {
                $('#courseGroups').DataTable({
                    processing: true,
                    searching: true,
                    serverSide: true,
                    ajax: '{!! url('groups/datatable-courses/') !!}' + '/' + groups,
                    "language": {
                        "url": "{{ asset('ar-datatable.json') }}"
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'title': '#'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            'title': 'الاسم'
                        },
                        {
                            data: 'category_id',
                            name: 'category_id',
                            'title': 'الفئة'
                        },
                        {
                            data: 'options',
                            name: 'options',
                            'title': 'العمليات'
                        },
                    ],
                });
            });
        @else
            $(function() {
                $('#courseGroups').DataTable({
                    processing: true,
                    searching: true,
                    // serverSide: true,
                    {{-- ajax: '{!! url('groups/datatable-courses/') !!}' + '/' + groups, --}} "language": {
                        "url": "{{ asset('ar-datatable.json') }}"
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'title': '#'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            'title': 'الاسم'
                        },
                        {
                            data: 'category_id',
                            name: 'category_id',
                            'title': 'الفئة'
                        },
                        {
                            data: 'options',
                            name: 'options',
                            'title': 'العمليات'
                        },
                    ],
                });
            });
        @endif
    </script>


    <script>
        var groups = '{{ $groups->id }}';


        @if (checkPermission('DatatableUsersFiles'))


            $(function() {
                $('#userFiles').DataTable({
                    processing: true,
                    searching: true,
                    serverSide: true,
                    ajax: '{!! url('groups/datatable-files/') !!}' + '/' + groups,
                    "language": {
                        "url": "{{ asset('ar-datatable.json') }}"
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'title': '#'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            'title': 'الاسم'
                        },
                        {
                            data: 'extension',
                            name: 'extension',
                            'title': 'النوع'
                        },
                        {
                            data: 'file_size',
                            name: 'file_size',
                            'title': 'الحجم'
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            'title': 'الوضوح'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            'title': 'تاريخ التحميل'
                        },
                        {
                            data: 'options',
                            name: 'options',
                            'title': 'العمليات'
                        },
                    ],
                });
            });
        @else
            $(function() {
                $('#userFiles').DataTable({
                    processing: true,
                    searching: true,
                    // serverSide: true,
                    {{-- ajax: '{!! url('groups/datatable-files/') !!}' + '/' + groups, --}} "language": {
                        "url": "{{ asset('ar-datatable.json') }}"
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'title': '#'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            'title': 'الاسم'
                        },
                        {
                            data: 'extension',
                            name: 'extension',
                            'title': 'النوع'
                        },
                        {
                            data: 'file_size',
                            name: 'file_size',
                            'title': 'الحجم'
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            'title': 'الوضوح'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            'title': 'تاريخ التحميل'
                        },
                        {
                            data: 'options',
                            name: 'options',
                            'title': 'العمليات'
                        },
                    ],
                });
            });
        @endif
    </script>


    <script>
        function readUrl(input) {

            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    let imgData = e.target.result;
                    let imgName = input.files[0].name;
                    input.setAttribute("data-title", imgName);
                    console.log(e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }

        }
    </script>


    <Script>
        // ************************ Drag and drop ***************** //
        let dropArea = document.getElementById("drop-area")

        // Prevent default drag behaviors
        ;
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false)
            document.body.addEventListener(eventName, preventDefaults, false)
        })

        // Highlight drop area when item is dragged over it
        ;
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false)
        })

        ;
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false)
        })

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false)

        function preventDefaults(e) {
            e.preventDefault()
            e.stopPropagation()
        }

        function highlight(e) {
            dropArea.classList.add('highlight')
        }

        function unhighlight(e) {
            dropArea.classList.remove('active')
        }

        function handleDrop(e) {
            var dt = e.dataTransfer
            var files = dt.files

            handleFiles(files)
        }

        let uploadProgress = []
        let progressBar = document.getElementById('progress-bar')

        function initializeProgress(numFiles) {
            progressBar.value = 0
            uploadProgress = []

            for (let i = numFiles; i > 0; i--) {
                uploadProgress.push(0)
            }
        }

        function updateProgress(fileNumber, percent) {
            uploadProgress[fileNumber] = percent
            let total = uploadProgress.reduce((tot, curr) => tot + curr, 0) / uploadProgress.length
            console.debug('update', fileNumber, percent, total)
            progressBar.value = total
        }

        function handleFiles(files) {
            files = [...files]
            initializeProgress(files.length)
            //files.forEach(uploadFile)
            files.forEach(previewFile)
        }

        function previewFile(file) {
            let reader = new FileReader()
            reader.readAsDataURL(file)
            reader.onloadend = function() {
                let img = document.createElement('img')
                img.src = reader.result
                document.getElementById('gallery').appendChild(img)
            }
        }

        function uploadFile(file, i) {
            var url = 'https://api.cloudinary.com/v1_1/joezimim007/image/upload'
            var xhr = new XMLHttpRequest()
            var formData = new FormData()
            xhr.open('POST', url, true)
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')

            // Update progress (can be used to show progress indicator)
            xhr.upload.addEventListener("progress", function(e) {
                updateProgress(i, (e.loaded * 100.0 / e.total) || 100)
            })

            xhr.addEventListener('readystatechange', function(e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    updateProgress(i, 100) // <- Add this
                } else if (xhr.readyState == 4 && xhr.status != 200) {
                    // Error. Inform the user
                }
            })

            formData.append('upload_preset', 'ujpu6gyk')
            formData.append('file', file)
            xhr.send(formData)
        }
    </Script>



    <script>
        // $(document).ready(function (e) {


        $("#btnSubmitModal").on('click', function(e) {

            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var file_id = $('.upload').attr('data-view');
            var group_id = $('.upload').attr('data-group');
            // console.log('mohamed');

            var fd = new FormData();
            var files = $('#file')[0].files[0];
            fd.append('file', files);

            @if (checkPermission('postupdatefilesUsers'))

                $.ajax({
                    type: 'POST',
                    url: "{{ url('files/postupdate') . '/' }}" + file_id + '/' + group_id,
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        $('#exampleModal').modal('toggle');
                        // location.reload(true);
                        $('#userFiles').DataTable().ajax.reload();

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            @endif
        });

        //  });




        $(document).ready(function() {
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    name: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },


                },

                messages: {
                    name: "{{ __('jsMessage.name') }}",
                    trainer_id: "{{ __('jsMessage.trainer_id') }}",

                },
                //display error alert on form submit
                invalidHandler: function(event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },

            });

        });
    </script>
@endsection
