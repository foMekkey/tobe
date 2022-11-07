@extends('backend.layouts.app')

@section('content')

    <div class="kt-wizard-v4" id="kt_apps_user_add_user" data-ktwizard-state="step-first">

    @include('errors.messages')
    <!--end: Form Wizard Nav -->
        <div class="kt-portlet">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-grid">
                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">

                        <!--begin: Form Wizard Form-->
                        <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postupdatenotifications',$notifications->id) }}" enctype="multipart/form-data">
                        @csrf
                        <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content"
                                 data-ktwizard-state="current">
                                <div class="kt-portlet__head kt-portlet__head--lg" style="">
                                    <div class="kt-portlet__head-label">
                                        <h2 class="kt-portlet__head-title">{{ __('pages.edit-notification') }} </h2>
                                    </div>
                                </div>

                                <div class="kt-section kt-section--first">
                                    <div class="kt-wizard-v4__form">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.notification-name') }} <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input class="form-control" name="name"  type="text" value="{{ ($notifications->name) ? $notifications->name  : old('$notifications') }}">
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.Trainer') }}  <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        {{Form::select('notifications_event_id',$events,$notifications->notifications_event_id,['class'=>'form-control','placeholder'=>__('pages.choose-event'), 'required'=>'required'])}}

                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.reciver') }} </label>
                                                    <div class=" col-lg-9 col-md-9 ">
                                                        <select required class="form-control kt-select2" id="kt_select2" name="notifier">
                                                            <option  selected>{{ __('pages.choose-reciver') }} </option>
                                                            @foreach($recivers as $key=>$reciver)
                                                                <option @if($key == $notifications->notifier) selected @endif value="{{ $key }}">{{ $reciver }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.desc') }} <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <textarea  class="form-control" name="notification" id="exampleTextarea" rows="3" spellcheck="false">{{ ($notifications->notification) ? $notifications->notification  : old('notification') }}</textarea>
                                                    </div>


                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">  </label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{account_owner_email}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.account_owner_email') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{account_owner_name}" onclick="insertAtCaret($(this).attr('data-ref'))"   ondragstart="return false;" ondrop="return false;">{{ __('pages.account_owner_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{account_owner_email}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.account_owner_email_user') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{account_owner_name}" onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.account_owner_name_user') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{account_owner_first_name}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.account_owner_first_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{related_user_email}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.related_user_email') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{related_user_name}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.related_user_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{related_user_first_name}"  onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.related_user_first_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{site_name}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;"> {{ __('pages.site_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{site_url}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.site_url') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline" data-ref="{time}"  onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.time') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{super_admin_email}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.super_admin_email') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{super_admin_name}" onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.super_admin_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{super_admin_first_name}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.super_admin_first_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{related_user_login}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.related_user_login') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px;" class="kt-badge kt-badge--success kt-badge--inline"  data-ref="{related_user_password}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.related_user_password') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{course_name}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.course_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{course_url}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.course_url') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{instructor_email}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.instructor_email') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{instructor_name}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.instructor_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{instructor_first_name}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.instructor_first_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{course_avg_score}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.course_avg_score') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{group_name}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{__('pages.group_name')}}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{assignment_name}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.assignment_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{submissions_url}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.submissions_url') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{ilt_name}" onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.ilt_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{session_name}" onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.session_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{learner_email}" onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.learner_email') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{learner_full_name}"  onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.learner_full_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{learner_first_name}"  onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.learner_first_name') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{ilt_users_url}" onclick="insertAtCaret($(this).attr('data-ref'))"  ondragstart="return false;" ondrop="return false;">{{ __('pages.ilt_users_url') }}</a>
                                                        <a href="javascript:void(0)" tabindex="-1" style="margin: 0px 5px 5px 0px; " class="kt-badge kt-badge--success kt-badge--inline" data-ref="{related_user_level}"  onclick="insertAtCaret($(this).attr('data-ref'))" ondragstart="return false;" ondrop="return false;">{{ __('pages.related_user_level') }}</a>

                                                    </div>

                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-3 col-form-label">{{ __('pages.status') }}</label>
                                                    <div class="col-9">
                                                        <div class="kt-checkbox-single">
                                                            <label class="kt-checkbox">
                                                                <input type="checkbox" name="status" value="1" @if($notifications->status == 1) checked @endif>
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

                                <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                        type="submit">
                                    {{ __('pages.edit') }}
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
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imageUpload").change(function () {
            readURL(this);
        });


        function insertAtCaret(e) {

            $("#exampleTextarea").val(function (_, val) {
                return val + e ;
            });
        }

        $(document).ready(function () {
            // configure your validation
            $('#kt_select2').select2({
                placeholder: "Select a state",
            });
            $('#kt_select2').on('select2:change', function(){
                validator.element($(this)); // validate element
            });



            $("#kt_form_1").validate({
// define validation rules
                rules: {
                    name: {
                        required: true,
                    },
                    notifications_event_id: {
                        required: true,
                    },
                    notification: {
                        required: true,
                    },
                    select2: {
                        required: true
                    },
                },

                messages: {
                    name: "{{__('jsMessage.name')}}",
                    notifications_event_id: "{{__('jsMessage.notifications_event_id')}}",
                    notification: "{{__('jsMessage.notification')}}",

                },
//display error alert on form submit
                invalidHandler: function (event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },
            });
        });
    </script>
@endsection
