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

    <div class="kt-wizard-v4" id="kt_apps_user_add_user" data-ktwizard-state="step-first">

       @include('errors.messages')
        <!--end: Form Wizard Nav -->
        <div class="kt-portlet">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-grid">
                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">

                        <!--begin: Form Wizard Form-->
                        <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postadduser') }}" enctype="multipart/form-data">
                           {{ csrf_field() }}
                            <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                <div class="kt-portlet__head kt-portlet__head--lg" style="">
                                    <div class="kt-portlet__head-label">
                                        <h2 class="kt-portlet__head-title"> {{ __('pages.add-user') }}</h2>
                                    </div>
                                </div>

                                <div class="kt-section kt-section--first">
                                    <div class="kt-wizard-v4__form">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.profile') }}</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_apps_user_add_avatar">
                                                            <div class="kt-avatar__holder" id="imagePreview" style="background-image: url(https://i.pravatar.cc/500?img=7);"></div>
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
                                                    <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.first-name') }} <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input  class="form-control" name="f_name" type="text" value="{{ old('f_name') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.last-name') }} <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input  class="form-control" name="l_name" type="text" value="{{ old('l_name') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.user-name') }} <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input  class="form-control" name="user_name" type="text" value="{{ old('user_name') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.password') }}<span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input  class="form-control" name="password" type="password" value="">
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.email') }} <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                            <input  type="text" class="form-control" name="email" value="{{ old('email') }}"  aria-describedby="basic-addon1">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{__('pages.user-type')}} <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <select name="type" id="user_type" class="form-control">
                                                            <option value="">{{__('pages.choose-user-type')}}</option>
                                                            @foreach($roles as $role)
                                                                <option value="{{$role->id}}">{{$role->role}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.cv') }} </label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <textarea class="form-control" name="bio" id="exampleTextarea" rows="3" spellcheck="false"></textarea></div>
                                                </div>
                                                <div id="certificates-container" class="form-group row" style="display: none">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.certificates') }} </label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <textarea class="form-control" id="certificates" name="certificates" rows="3" spellcheck="false"></textarea></div>
                                                </div>
                                                <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.tag') }}  </label>
                                                        <div class="col-lg-9 col-xl-9">
                                                            <input type="text" name="tags" class="form-control" value="" data-role="tagsinput" />
                                                        </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-3 col-form-label">{{ __('pages.status') }}  </label>
                                                    <div class="col-9">
                                                        <div class="kt-checkbox-single">
                                                            <label class="kt-checkbox">
                                                                <input type="checkbox" name="status" value="1">
                                                                <span></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!--end: Form Wizard Step 1-->

                            <!--begin: Form Actions -->
                            <div class="kt-form__actions">

                                <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                                      {{ __('pages.save') }}
                                </button>

                            </div>

                            <!--end: Form Actions -->
                        </form>
                        <!--end: Form Wizard Form-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
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
                  password: {
                      required: true,
                  },
                  email: {
                      required: true,
                  },
                  type: {
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
