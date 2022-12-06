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
    @include('errors.messages')

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul id="myTab" class="nav nav-tabs nav-tabs-space-xl nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_user_edit_tab_1" role="tab">
                            <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon id="Bound" points="0 0 24 0 24 24 0 24" />
                                    <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" id="Shape" fill="#000000" fill-rule="nonzero" />
                                    <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" id="Path" fill="#000000" opacity="0.3" />
                                </g>
                            </svg> {{ __('pages.courses') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_apps_user_edit_tab_2" role="tab">
                            <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" id="Mask" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" id="Mask-Copy" fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg> {{ __('pages.users') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_apps_user_edit_tab_3" role="tab">
                            <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                    <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" id="Path-50" fill="#000000" opacity="0.3" />
                                    <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" id="Mask" fill="#000000" opacity="0.3" />
                                    <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" id="Mask-Copy" fill="#000000" opacity="0.3" />
                                </g>
                            </svg> {{ __('pages.groups') }}
                        </a>
                    </li>

                </ul>
            </div>
        </div>



        <div class="kt-portlet__body">
            <form action="{{ route('postupdatecoursesTrainer',['id'=>$courses->id]) }}" method="post" id="kt_form_1" enctype="multipart/form-data">
                @csrf
                <div class="tab-content">
                    <div class="tab-pane active" id="kt_apps_user_edit_tab_1" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.profile') }} <span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_apps_user_add_avatar">
                                                    <div class="kt-avatar__holder" id="imagePreview" style="background-image: url('{{ asset("uploads/".$courses->image) }}');"></div>
                                                    <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
                                                        <i class="fa fa-pencil"></i>
                                                        <input  type="file" name="image" id="imageUpload">
                                                    </label>
                                                    <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
																<i class="fa fa-times"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.course-name') }}     <span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input  class="form-control" name="name" type="text" value="{{ ($courses->name) ? $courses->name  : old('name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.category') }} <span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-9">
                                                {{Form::select('category_id',$coursesCategories,$courses->category_id,['class'=>'form-control','placeholder'=>__('pages.choose-category')])}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.level') }} <span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-9">
                                                <select class="form-control"  name="level" >
                                                    <option selected> {{ __('pages.choose-level') }} </option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}" @if($courses->level == $i) selected @endif>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.desc') }} <span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-9">
                                                <textarea  class="form-control" name="desc" id="exampleTextarea" rows="3" spellcheck="false">{{ $courses->desc }}</textarea>                                                        </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.content') }}</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <textarea id="summernote" name="content">{!! $courses->content !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.data-start-and-end') }}<span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input type='text' class="form-control" id="daterangepicker"   readonly placeholder="Select time" value="{{ $startdate }} - {{ $enddate }}" name="dateRange" />
                                                {{--<input type='text' class="form-control" id="daterangepicker"   readonly placeholder="Select time" value="04/07/2019 - 11/08/2019" name="dateRange" />--}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.price') }} <span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input  type="number" name="price" class="form-control" value="{{ $courses->price }}"  />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.peroid') }} <span style="color: red">*</span></label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input type="number"  name="duration" class="form-control" value="{{ $courses->duration }}"  />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.rules_of_achievement') }}</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <textarea class="form-control" name="complete_rules" rows="3" spellcheck="false">{{ $courses->complete_rules }}</textarea>                                                        </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.tag') }} </label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input type="text" name="tags" class="form-control" value="{{ $courses->tags }}" data-role="tagsinput" />
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.types') }}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="kt-checkbox-inline">
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox" name="status" value="1" @if($courses->status == 1) checked @endif >{{ __('pages.status') }}
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox" name="hide_from_catalog" value="1" @if($courses->hide_from_catalog == 1) checked @endif>{{ __('pages.catalog') }}
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-form__actions">
                                            <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                                                {{ __('pages.save') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>

            <div class="tab-pane" id="kt_apps_user_edit_tab_2" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>

                                        </div>


                                        <table class="table table-striped- table-bordered table-hover table-checkable" id="userCourses">
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
                        </div>
                    </div>
                    <div class="tab-pane" id="kt_apps_user_edit_tab_3" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="groupsCourses">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>name</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                            </table>

                        </div>
                    </div>

                </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/forms/widgets/bootstrap-daterangepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/summernote.min.js') }}" type="text/javascript"></script>
    <script>
        var italian_daterangepicker = {
            "direction": "rtl",
            "format": "MM/DD/YYYY",
            "separator": " - ",
            "applyLabel": "عرض",
            "cancelLabel": "إغلاق",
            "fromLabel": "Da",
            "toLabel": "A",
            "isRTL": true,
            "customRangeLabel": "Personalizzata",
            "daysOfWeek": [
                'ح', 'ن', 'ث', 'ر', 'خ', 'ج', 'س'
            ],
            "monthNames": [
                "يناير",
                "فبراير",
                "مارس",
                "ابريل",
                "مايو",
                "يونيو",
                "يوليو",
                "اغسطس",
                "سبتمبر",
                "اكتوبر",
                "نوفمبر",
                "ديسمبر"
            ],
            "firstDay": 1
        };
        $('#daterangepicker').daterangepicker({
            locale : italian_daterangepicker,
            //singleDatePicker: false,
        });

    </script>


    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>

    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>

    <!--begin::Page Vendors(used by this page) -->
    <script src="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <!--end::Page Vendors -->
    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/datatables/advanced/column-rendering.js') }}" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

    </script>


    <script>
        var courses = '{{ $courses->id }}';
        $(function() {
            $('#userCourses').DataTable({
                processing: true,
                searching: true,
                serverSide: true,
                ajax: '{!! url('trainer/courses/datatable-users/') !!}' + '/' + courses,
                "language": {
                    "url": "{{ asset('ar-datatable.json')  }}"
                },
                columns: [
                    { data: 'id', name: 'id','title':'#' },
                    { data: 'user_name', name: 'user_name' ,'title':'الاسم'},
                    { data: 'type', name: 'type','title':'الدور' },
                    { data: 'options', name: 'options' ,'title':'العمليات' },
                ],
            });
        });
    </script>



    <script>
        var courses = '{{ $courses->id }}';
        $(function() {
            $('#groupsCourses').DataTable({
                processing: true,
                searching: true,
                serverSide: true,
                ajax: '{!! url('trainer/courses/datatable-groups/') !!}' + '/' + courses,
                "language": {
                    "url": "{{ asset('ar-datatable.json')  }}"
                },
                columns: [
                    { data: 'id', name: 'id','title':'#' },
                    { data: 'name', name: 'name' ,'title':'الاسم'},
                    { data: 'options', name: 'options' ,'title':'العمليات' },
                ],
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            $('#daterangepicker').validate();
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    select2: {
                        required: true
                    },
                    name: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    level: {
                        required: true,
                    },
                    select: {
                        required: true,
                    },
                    desc: {
                        required: true,
                    },
                    dateRange: {
                        required: true,
                    },
                    price: {
                        required: true,
                    },
                    duration: {
                        required: true,
                    },
                },

                messages: {
                    name: "{{__('jsMessage.name')}}",
                    category_id: "{{__('jsMessage.category_id')}}",
                    level: "{{__('jsMessage.level')}}",
                    desc: "{{__('jsMessage.desc')}}",
                    price: "{{__('jsMessage.price')}}",
                    duration: "{{__('jsMessage.duration')}}",

                },
                //display error alert on form submit
                invalidHandler: function (event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },

            });

        });
        
        $('#summernote').summernote({
            callbacks: {
                onImageUpload: function(files) {
                    for(let i=0; i < files.length; i++) {
                        $.upload(files[i]);
                    }
                }
            },
            height: 300,
        });

        $.upload = function (file) {
            let out = new FormData();
            out.append('file', file, file.name);

            $.ajax({
                method: 'POST',
                url: '{{ url('upload') }}',
                contentType: false,
                cache: false,
                processData: false,
                data: out,
                success: function (img) {
                    $('#summernote').summernote('insertImage', img);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        };
    </script>


@endsection




