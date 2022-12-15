@extends('backend.layouts.app')

@section('content')
    @include('errors.messages')

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.edit-subscription') }}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <form action="{{ route('postupdatesubscription',['id'=>$subscription->id]) }}" method="post" id="kt_form_1" enctype="multipart/form-data">
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
                            <select class="form-control" id="kt_course" name="user_id">
                                @foreach($students as $id => $name)
                                    <option value="{{$id}}"@if($id == $subscription->user_id) selected @endif>
                                       {{$name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.course') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control" id="kt_course" name="course_id">
                                @foreach($courses as $id => $name)
                                    <option value="{{$id}}"@if($id == $subscription->course_id) selected @endif>
                                         {{$name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.payment_method') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control" id="kt_course" name="payment_method">
                                <option value="0" @if(0 == $subscription->payment_method) selected @endif> {{ __('pages.bank_transfer') }} </option>
                                <option value="1" @if(1 == $subscription->payment_method) selected @endif > {{ __('pages.e_wallet_transfer') }} </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.banks') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control" id="kt_course" name="bank_id">
                                <option value="" selected> {{ __('pages.choose-bank') }} </option>
                                @foreach($banks as $bank)
                                    <option value="{{$bank->id}}" @if($bank->id == $subscription->bank_id) selected @endif>
                                      {{$bank->acc_num}} {{$bank->acc_name_ar}}
                                      
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.user_bank_acc_name') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="user_bank_acc_name" type="text" value="{{ ($subscription->user_bank_acc_name) ? $subscription->user_bank_acc_name  : old('user_bank_acc_name') }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.e_wallets') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control" id="kt_course" name="e_wallet_id">
                                <option value="" selected> {{ __('pages.choose-e_wallet') }} </option>
                                @foreach($e_wallets as $e_wallet)
                                    <option value="{{$e_wallet->id}}" @if($e_wallet->id == $subscription->e_wallet_id) selected @endif >
                                     {{$e_wallet->number}} {{$e_wallet->company_name_ar}} 
                                      
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.user_e_wallet_number') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="user_e_wallet_number" type="text" value="{{ ($subscription->user_e_wallet_number) ? $subscription->user_e_wallet_number  : old('user_e_wallet_number') }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.transfer_date') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control" id="kt_course" type="date" name="transfer_date" value="{{ ($subscription->transfer_date) ? $subscription->transfer_date  : old('transfer_date') }}">
                            
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.types') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control" id="kt_course" name="status">
                                <option value="0" @if(0 == $subscription->status) selected @endif > {{ __('pages.pending') }} </option>
                                <option value="1" @if(1 == $subscription->status) selected @endif> {{ __('pages.accepted') }} </option>
                                <option value="2" @if(2 == $subscription->status) selected @endif> {{ __('pages.rejected') }} </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="kt-form__actions">
                        <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                            {{ __('pages.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('js/summernote.min.js') }}" type="text/javascript"></script>    
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
