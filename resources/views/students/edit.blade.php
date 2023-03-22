@extends('backend.layouts.app')
@section('style')
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
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
            width: 100% ;
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
    <div class="kt-portlet kt-portlet--tabs">
        @include('errors.messages')
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul  id="myTab" class="nav nav-tabs nav-tabs-space-xl nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_user_edit_tab_1" role="tab">
                            <svg xmlns="//www.w3.org/2000/svg" xmlns:xlink="//www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon id="Bound" points="0 0 24 0 24 24 0 24" />
                                    <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" id="Shape" fill="#000000" fill-rule="nonzero" />
                                    <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" id="Path" fill="#000000" opacity="0.3" />
                                </g>
                            </svg> {{ __('pages.data') }}
                        </a>
                    </li>
                   
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="kt_apps_user_edit_tab_1" role="tabpanel">
                <form action="{{ route('postUpdateStudent' , ['id'=>$users->id]) }}" id="kt_form_1" method="post" enctype="multipart/form-data">
                    @csrf
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
                                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.profile') }}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_apps_user_add_avatar">
                                                <div class="kt-avatar__holder" id="imagePreview" style="background-image: url('{{ asset("uploads/".$users->image) }}');"></div>
                                                <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
                                                    <i class="fa fa-pencil"></i>
                                                    <input type="file" name="image" id="imageUpload">
                                                </label>
                                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.first-name') }}  <span style="color: red">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <input  class="form-control" name="f_name" type="text" value="{{ ($users->f_name) ? $users->f_name  : old('f_name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.last-name') }} <span style="color: red">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <input  class="form-control" name="l_name" type="text" value="{{ ($users->l_name) ? $users->l_name  : old('l_name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.user-name') }}  <span style="color: red">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <input  class="form-control" name="user_name" type="text" value="{{ ($users->user_name) ? $users->user_name  : old('user_name') }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">   {{ __('pages.password') }} </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <input class="form-control" name="password" type="password" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.email') }}  <span style="color: red">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                <input  type="text" class="form-control" name="email" value="{{ ($users->email) ? $users->email  : old('email') }}" placeholder="Email" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>

                                   

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.cv') }} </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <textarea class="form-control" name="bio" id="exampleTextarea" rows="3" spellcheck="false">{{ $users->bio }}</textarea></div>
                                    </div>
                                    
                                    

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin: Form Actions -->
                    <div class="kt-form__actions">
                        <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                            {{ __('pages.save') }}
                        </button>
                    </div>
                    <!--end: Form Actions -->
                </form>
                </div>
                <div class="tab-pane" id="kt_apps_user_edit_tab_2" role="tabpanel">
                    <div class="kt-form kt-form--label-right">
                        <div class="kt-form__body">
                            <div class="kt-section kt-section--first">
                                <table class="table table-striped- table-bordered table-hover table-checkable" id="userCourses">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>name</th>
                                        <th>status</th>
                                        <th>user</th>
                                        <th>start_date</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="kt_apps_user_edit_tab_3" role="tabpanel">
                    <div class="kt-form kt-form--label-right">
                        <div class="kt-form__body">
                            <div class="kt-section kt-section--first">

                                <table class="table table-striped- table-bordered table-hover table-checkable" id="userGroups">
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
                <div class="tab-pane" id="kt_apps_user_edit_tab_4" role="tabpanel">
                    <div class="kt-form kt-form--label-right">
                        <div class="kt-form__body">
                            <div class="form-group row">
                               <form method="post" action="{{ route('postadduserfiles',['user_id'=>$users->id]) }}" enctype="multipart/form-data">
                                   @csrf
                                <div id="drop-area">

                                    <div id="data">

                                        <i class="flaticon-upload"></i>
                                        <p>اختر الملفات لتحميلها أو اسحبها وأسقطها هنا</p>

                                        <input type="file" name="FileUploaded" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
                                        <label class="button" for="fileElem">اختر الملف</label>

                                    <progress id="progress-bar" max=100 value=0></progress>
                                    <div id="gallery" /></div>
                                </div>


                                   <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                                       تحميل
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- <form> --}}

            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label"> اسم المجموعة <span style="color: red">*</span></label>
                    <div class="col-lg-9 col-xl-9">
                        <input class="form-control" name="FileUploaded" id="file" required type="file" >
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                <button type="button" id="btnSubmitModal" class="btn btn-primary">حفظ</button>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    <!--begin::Page Vendors(used by this page) -->
    <script src="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="//cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <!--end::Page Vendors -->
    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/datatables/advanced/column-rendering.js') }}" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
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

        @if(checkPermission('DatatableCourses'))
            var users = '{{ $users->id }}';
            $(function() {
                $('#userCourses').DataTable({
                    processing: true,
                    searching: true,
                    serverSide: true,
                    ajax: '{!! url('users/datatable-course/') !!}' + '/' + users,
                    "language": {
                        "url": "{{ asset('ar-datatable.json')  }}"
                    },
                    columns: [
                        { data: 'id', name: 'id','title':'#' },
                        { data: 'name', name: 'user_name' ,'title':'الاسم'},
                        { data: 'status', name: 'email','title':'الحالة ' },
                        { data: 'user', name: 'user','title':'الدور ' },
                        { data: 'start_date', name: 'start_date','title':'بداية الدورة ' },
                        { data: 'options', name: 'options' ,'title':'العمليات' },
                    ],
                });
            });
        @else
            $(function() {
                $('#userCourses').DataTable({
                    processing: true,
                    searching: true,
                  //  serverSide: true,
                   // ajax: '{!! url('users/datatable-course/') !!}' + '/' + users,
                    "language": {
                        "url": "{{ asset('ar-datatable.json')  }}"
                    },
                    columns: [
                        { data: 'id', name: 'id','title':'#' },
                        { data: 'name', name: 'user_name' ,'title':'الاسم'},
                        { data: 'status', name: 'email','title':'الحالة ' },
                        { data: 'user', name: 'user','title':'الدور ' },
                        { data: 'start_date', name: 'start_date','title':'بداية الدورة ' },
                        { data: 'options', name: 'options' ,'title':'العمليات' },
                    ],
                });
            });
        @endif

        var users = '{{ $users->id }}';
        @if(checkPermission('DatatableGroups'))
            $(function() {
                $('#userGroups').DataTable({
                    processing: true,
                    searching: true,
                    serverSide: true,
                    ajax: '{!! url('users/datatable-groups/') !!}' + '/' + users,
                    "language": {
                        "url": "{{ asset('ar-datatable.json')  }}"
                    },
                    columns: [
                        { data: 'id', name: 'id','title':'#' },
                        { data: 'name', name: 'user_name' ,'title':'الاسم'},
                        { data: 'options', name: 'options' ,'title':'العمليات' },
                    ],
                });
            });
        @else
            $(function() {
                $('#userGroups').DataTable({
                    processing: true,
                    searching: true,
                   // serverSide: true,
                 //   ajax: '{!! url('users/datatable-groups/') !!}' + '/' + users,
                    "language": {
                        "url": "{{ asset('ar-datatable.json')  }}"
                    },
                    columns: [
                        { data: 'id', name: 'id','title':'#' },
                        { data: 'name', name: 'user_name' ,'title':'الاسم'},
                        { data: 'options', name: 'options' ,'title':'العمليات' },
                    ],
                });
            });
        @endif

        var users = '{{ $users->id }}';
        @if(checkPermission('DatatableUsersFiles'))
            $(function() {
                $('#userFiles').DataTable({
                    processing: true,
                    searching: true,
                    serverSide: true,
                    ajax: '{!! url('users/datatable-files/') !!}' + '/' + users,
                    "language": {
                        "url": "{{ asset('ar-datatable.json')  }}"
                    },
                    columns: [
                        { data: 'id', name: 'id','title':'#' },
                        { data: 'name', name: 'name' ,'title':'الاسم'},
                        { data: 'extension', name: 'extension' ,'title':'النوع'},
                        { data: 'file_size', name: 'file_size' ,'title':'الحجم'},
                        { data: 'is_active', name: 'is_active' ,'title':'الوضوح'},
                        { data: 'created_at', name: 'created_at' ,'title':'تاريخ التحميل'},
                        { data: 'options', name: 'options' ,'title':'العمليات' },
                    ],
                });
            });
        @else
            $(function() {
                $('#userFiles').DataTable({
                    processing: true,
                    searching: true,
    //                serverSide: true,
    //                ajax: '{!! url('users/datatable-files/') !!}' + '/' + users,
                    "language": {
                        "url": "{{ asset('ar-datatable.json')  }}"
                    },
                    columns: [
                        { data: 'id', name: 'id','title':'#' },
                        { data: 'name', name: 'name' ,'title':'الاسم'},
                        { data: 'extension', name: 'extension' ,'title':'النوع'},
                        { data: 'file_size', name: 'file_size' ,'title':'الحجم'},
                        { data: 'is_active', name: 'is_active' ,'title':'الوضوح'},
                        { data: 'created_at', name: 'created_at' ,'title':'تاريخ التحميل'},
                        { data: 'options', name: 'options' ,'title':'العمليات' },
                    ],
                });
            });
        @endif

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

        // ************************ Drag and drop ***************** //
        let dropArea = document.getElementById("drop-area")

// Prevent default drag behaviors
        ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false)
            document.body.addEventListener(eventName, preventDefaults, false)
        })

// Highlight drop area when item is dragged over it
        ;['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false)
        })

        ;['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false)
        })

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false)

        function preventDefaults (e) {
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

            for(let i = numFiles; i > 0; i--) {
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
            var url = '//api.cloudinary.com/v1_1/joezimim007/image/upload'
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
                }
                else if (xhr.readyState == 4 && xhr.status != 200) {
                    // Error. Inform the user
                }
            })

            formData.append('upload_preset', 'ujpu6gyk')
            formData.append('file', file)
            xhr.send(formData)
        }

        // $(document).ready(function (e) {
        $("#btnSubmitModal").on('click', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var file_id = $('.upload').attr('data-view');
            var user_id = $('.upload').attr('data-user');
            // console.log('mohamed');

            var fd = new FormData();
            var files = $('#file')[0].files[0];
            fd.append('file',files);

            @if(checkPermission('postupdatefilesUsers'))
                $.ajax({
                    type:'POST',
                    url: "{{ url('users/postupdate') .'/'}}" + file_id + '/' + user_id,
                    data:fd,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                       // console.log(data);
                        $('#exampleModal').modal('toggle');
                        // location.reload(true);
                        $('#userFiles').DataTable().ajax.reload();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            @endif
        });
        //  });

        $(document).ready(function () {
            $('#type_kt').validate();
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    select2: {
                        required: true
                    },
                    f_name: {
                        required: true,
                    },
                    l_name: {
                        required: true,
                    },
                    user_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                  
                },

                messages: {
                    f_name: "{{__('jsMessage.name')}}",
                    l_name: "{{__('jsMessage.l_name')}}",
                    user_name: "{{__('jsMessage.user_name')}}",
                    password: "{{__('jsMessage.password')}}",
                    email: "{{__('jsMessage.email')}}",
                    type: "{{__('jsMessage.type')}}",
                },
                //display error alert on form submit
                invalidHandler: function (event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },
            });
        });
        
        $('#user_type').change(function() {
            if ($(this).val() == '3') {
                $('#certificates-container').show();
            } else {
                $('#certificates').text("");
                $('#certificates-container').hide();
            }
        });
    </script>
@endsection
