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
    </style>
@endsection
@section('content')

    @include('errors.messages')



    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ __('pages.add-new-subscription') }}
                    </h3>
                </div>
            </div>

            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postaddsubscription') }}" enctype="multipart/form-data">
                @csrf
                <div class="kt-portlet__body">
                    <div class="kt-form__content">
                        <div class="kt-alert m-alert--icon alert alert-danger kt-hidden" role="alert" id="kt_form_1_msg">
                            <div class="kt-alert__icon">
                                <i class="la la-warning"></i>
                            </div>
                            <div class="kt-alert__text">
                                Oh snap! Change a few things up and try submitting again.
                            </div>
                            <div class="kt-alert__close">
                                <button type="button" class="close" data-close="alert" aria-label="Close">
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.user') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            {{Form::select('user_id',$students,null,['class'=>'form-control','id'=>'kt_user','placeholder'=> __('pages.choose-user')])}}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.course') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            {{Form::select('course_id',$courses,null,['class'=>'form-control','id'=>'kt_course','placeholder'=> __('pages.choose-course')])}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.payment_method') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control"  name="payment_method" >
                                <option value="" selected> {{ __('pages.choose-payment_method') }} </option>
                                <option value="0"> {{ __('pages.e_wallet_transfer') }} </option>
                                <option value="1"> {{ __('pages.bank_transfer') }} </option>
                            </select>

                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.amount') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="amount" type="text" value="{{ old('amount') }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.currency') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="currency" type="text" value="{{ old('currency') }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.banks') }} </label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control" id="kt_course" name="bank_id">
                                <option value="" selected> {{ __('pages.choose-bank') }} </option>
                                @foreach($banks as $bank)
                                    <option value="{{$bank->id}}">
                                     {{$bank->acc_name_ar}} {{$bank->acc_num}} 
                                      
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.user_bank_acc_name') }}     </label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="user_bank_acc_name" type="text" value="{{ old('user_bank_acc_name') }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.e_wallets') }} </label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control" id="kt_course" name="e_wallet_id">
                                <option value="" selected> {{ __('pages.choose-e_wallet') }} </option>
                                @foreach($e_wallets as $e_wallet)
                                    <option value="{{$e_wallet->id}}">
                                     {{$e_wallet->number}} {{$e_wallet->company_name_ar}} 
                                      
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.user_e_wallet_number') }}    </label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="user_e_wallet_number" type="text" value="{{ old('user_e_wallet_number') }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.transfer_date') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control" id="kt_course" type="date" name="transfer_date">
                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.types') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control"  name="status" >
                                <option value="" selected> {{ __('pages.choose-status') }} </option>
                                <option value="0"> {{ __('pages.pending') }} </option>
                                <option value="1"> {{ __('pages.accepted') }} </option>
                                <option value="2"> {{ __('pages.rejected') }} </option>
                            </select>

                        </div>
                    </div>
                    
                </div>
                <div class="kt-form__actions">

                    <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                        {{ __('pages.save') }}
                    </button>

                </div>

            </form>

            <!--end::Form-->
        </div>

        <!--end::Portlet-->
    </div>



@endsection


@section('script')
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/forms/widgets/bootstrap-daterangepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/summernote.min.js') }}" type="text/javascript"></script>    
   

    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
    <script>
       
        

        $(document).ready(function () {
           
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    user_id: {
                        required: true
                    },
                    course_id: {
                        required: true,
                    },
                    payment_method: {
                        required: true,
                    },
                    transfer_date: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },
                    bank_id: {
                        required: false,
                    },
                    user_bank_acc_name: {
                        required: false,
                    },

                    e_wallet_id: {
                        required: false,
                    },
                    user_e_wallet_number: {
                        required: false,
                    },
                },

                messages: {
                    user_id: "{{__('jsMessage.user_id')}}",
                    

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
