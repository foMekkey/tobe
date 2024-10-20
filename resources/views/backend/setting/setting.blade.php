@extends('backend.layouts.app')
@section('style')
    <style>
        .kt-widget5 .kt-widget5__item .kt-widget5__content:last-child
        {
            justify-content: right;
            text-align: right;
        }

        .kt-widget5__item
        {
            margin-bottom: -15px !important
        }

        .check
        {
            line-height: 1px
        }
    </style>
    @endsection
@section('content')

    @include('errors.messages')

    <div class="kt-portlet kt-portlet--height-fluid" style="direction: rtl">

        {{-- head --}}
        <div class="kt-portlet__head">

            <div class="kt-portlet__head-toolbar">
                <ul id="myTab" class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_widget5_tab1_content" role="tab" aria-selected="false">
                            {{ __('pages.main-setting') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#kt_widget5_tab2_content" role="tab" aria-selected="false">
                            {{ __('pages.users') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#kt_widget5_tab3_content" role="tab" aria-selected="false">

                            {{ __('pages.games') }}

                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- body --}}
        <div class="kt-portlet__body">
            <div class="tab-content">

                {{-- first tap --}}
                <div class="tab-pane active" id="kt_widget5_tab1_content" aria-expanded="true">
                    <form action="{{route('updatefirsttap')}}" id="kt_form_1" method="post">
                        {{csrf_field()}}
                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%;">
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.site-name') }}<span style="color: red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" value="{{$site_name}}" name="site_name" class="form-control" id="kt_datepicker_1" placeholder="إسم الموقع" maxlength="190" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2"> {{ __('pages.site-desc') }}<span style="color: red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" value="{{$site_disc}}" name="site_disc" class="form-control" id="kt_datepicker_1" placeholder="وصف الموقع" maxlength="190" >
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.main-setting') }}<span style="color: red">*</span></label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="default_lang">
                                                    <option value="ar">{{ __('pages.arabic') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <h5 style="border-bottom: 5px solid #ccc;margin-bottom: 25px"></h5>

                        {{-- ---------------------------- --}}


                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.enter-ad') }}<span style="color: red">*</span></label>
                                            <div class="col-sm-4">
                                                <textarea class="form-control"  name="out_side_baner" placeholder="إعلان داخلي" >{{$out_side_baner}}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.out-ad') }} <span style="color: red">*</span></label>
                                            <div class="col-sm-4">
                                                 <textarea class="form-control" name="in_side_baner" placeholder="إعلان خارجي" >{{$in_side_baner}}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <h5 style="border-bottom: 5px solid #ccc;margin-bottom: 25px"></h5>

                        {{-- ---------------------------- --}}


                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">
                                        <div class="form-group row">
                                            <div class="col-xl-8 col-lg-8 col-sm-12 col-md-12">
                                                <div class="kt-checkbox-inline">
                                                    <label class="kt-checkbox">
                                                        @if($prevent_multi_enter != 'on')
                                                            <input type="checkbox" name="prevent_multi_enter" value="on">{{ __('pages.multiaut') }}
                                                        @else
                                                            <input type="checkbox" name="prevent_multi_enter" checked="" value="on">{{ __('pages.multiaut') }}
                                                        @endif
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-xl-8 col-lg-8 col-sm-12 col-md-12">
                                                <div class="kt-checkbox-inline">
                                                    <label class="kt-checkbox">
                                                         @if($prevent_phone_enter != 'on')
                                                            <input type="checkbox" name="prevent_phone_enter" value="on"> {{ __('pages.mobile_enter') }}
                                                        @else
                                                            <input type="checkbox" name="prevent_phone_enter" checked="" value="on"> {{ __('pages.mobile_enter') }}
                                                        @endif
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-xl-8 col-lg-8 col-sm-12 col-md-12">
                                                <div class="kt-checkbox-inline">
                                                    <label class="kt-checkbox">
                                                        @if($index_out_course != 'on')
                                                            <input type="checkbox" name="index_out_course" value="on">{{ __('pages.index-course') }}
                                                        @else
                                                            <input type="checkbox" name="index_out_course" checked="" value="on"> {{ __('pages.index-course') }}
                                                        @endif
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-xl-8 col-lg-8 col-sm-12 col-md-12">
                                                <div class="kt-checkbox-inline">
                                                    <label class="kt-checkbox">
                                                        @if($view_summary_session != 'on')
                                                            <input type="checkbox" name="view_summary_session" checked="" value="on"> {{ __('pages.show-little') }}
                                                        @else
                                                            <input type="checkbox" name="view_summary_session" value="on">{{ __('pages.show-little') }}
                                                        @endif
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 style="border-bottom: 5px solid #ccc;margin-bottom: 25px"></h5>

                        {{-- ---------------------------- --}}

                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%;">
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.link') }} </label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" value="{{$ink_based_bbb}}" name="ink_based_bbb" id="kt_datepicker_1" placeholder="رابط اساس BBB" maxlength="190" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.saveBB') }} </label>
                                            <div class="col-sm-4">
                                                <input type="text" name="ink_safety_bbb" value="{{$ink_safety_bbb}}" class="form-control" id="kt_datepicker_1" placeholder="ملح امان BBB" maxlength="190" >
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.max') }}</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="maximum_capacity" value="{{$maximum_capacity}}" class="form-control" id="kt_datepicker_1" placeholder="سعه قصوى" >
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 style="border-bottom: 5px solid #ccc;margin-bottom: 25px"></h5>

                        {{-- ---------------------------- --}}
                        <div class="col-sm-2 text-center">
                            <button type="submit" class="btn btn-success">{{ __('pages.save') }}</button>
                        </div>
                    </form>
                </div>

                {{-- second tap --}}
                <div class="tab-pane" id="kt_widget5_tab2_content">
                    <form action="{{route('updatesecondtap')}}" method="post">
                        {{csrf_field()}}
                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%;">
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.register') }} <span style="color: red">*</span></label>
                                            <div class="col-sm-4">
                                               <select class="form-control" name="register_type">
                                                   <option value="live" >{{ __('pages.live') }}</option>
                                               </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.user-main') }} <span style="color: red">*</span></label>
                                            <div class="col-sm-4">
                                               <select class="form-control" name="user_default_type">
                                                   <option value="learner-type">learner-type</option>
                                               </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.defult-groups') }}<span style="color: red">*</span></label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="default_group">
                                                    <option value="group">{{ __('pages.choose-group') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2">{{ __('pages.terms') }}<span style="color: red">*</span></label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="terms_of_service" rows="6" placeholder="{{ __('pages.termss') }}" required="">{{$terms_of_service}}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 style="border-bottom: 5px solid #ccc;margin-bottom: 25px"></h5>
                        {{-- ---------------------------- --}}

                        <div class="col-sm-2 text-center">
                            <button type="submit" class="btn btn-success">{{ __('pages.save') }}</button>
                        </div>
                    </form>
                </div>

                {{-- third tap --}}
                <div class="tab-pane" id="kt_widget5_tab3_content">
                    <form action="{{route('updatethirdtap')}}" method="post">
                        {{csrf_field()}}
                        @if($check_points_group === 'on')
                        <div class="alert alert-success">{{ __('pages.points') }} <input type="checkbox" class="form-control" checked="" name="check_points_group" value="on" style="height: 20px"></div>
                        @else
                        <div class="alert alert-success">{{ __('pages.points') }} <input type="checkbox" class="form-control" name="check_points_group" value="on" style="height: 20px"></div>
                        @endif
                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%;">
                                        <div class="form-group row">
                                            <div >
                                                @if($check_enter === 'on')
                                                    <input type="checkbox" checked="" name="check_enter" value="on">
                                                @else
                                                    <input type="checkbox" name="check_enter" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.all-login-add') }}</label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$enter}}" name="enter" >
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.points') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >

                                                @if($check_complete_unit === 'on')
                                                    <input type="checkbox" checked="" name="check_complete_unit" value="on">
                                                @else
                                                    <input type="checkbox" name="check_complete_unit" value="on">
                                                @endif

                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.all-point-finsih') }}</label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$complete_unit}}" name="complete_unit" >
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.points') }}</span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div>
                                                @if($check_complete_course === 'on')
                                                    <input type="checkbox" checked="" name="check_complete_course" value="on">
                                                @else
                                                    <input type="checkbox" name="check_complete_course" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.add-couese-finish') }}</label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$complete_course}}" name="complete_course" >
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.points') }}</span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($check_complete_test === 'on')
                                                    <input type="checkbox" checked="" name="check_complete_test" value="on">
                                                @else
                                                    <input type="checkbox" name="check_complete_test" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.add-exam-add') }}</label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$complete_test}}" name="complete_test" >
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.points') }}</span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div>
                                                @if($check_complete_mission === 'on')
                                                    <input type="checkbox" checked="" name="check_complete_mission" value="on">
                                                @else
                                                    <input type="checkbox" name="check_complete_mission" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.mission') }}</label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$complete_mission}}" name="complete_mission" >
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.points') }}</span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($check_complete_unit_with_treaner === 'on')
                                                    <input type="checkbox" checked="" name="check_complete_unit_with_treaner" value="on">
                                                @else
                                                    <input type="checkbox" name="check_complete_unit_with_treaner" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.all-finsih-course') }}</label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$complete_unit_with_treaner}}" name="complete_unit_with_treaner" >
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.points') }}</span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($check_subject_or_comment === 'on')
                                                <input type="checkbox" checked="" name="check_subject_or_comment" value="on">
                                                @else
                                                <input type="checkbox" name="check_subject_or_comment" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.all-discussion-add') }}</label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$subject_or_comment}}" name="subject_or_comment" >
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.points') }}</span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($check_vote === 'on')
                                                    <input type="checkbox" checked="" name="check_vote" value="on">
                                                @else
                                                    <input type="checkbox" name="check_vote" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.all-vot-add') }}</label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$vote}}" name="vote" >
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.points') }}</span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($check_badges_group === 'on')
                            <div class="alert alert-success">{{ __('pages.charat') }} <input type="checkbox" checked="" class="form-control" name="check_badges_group" value="on" style="height: 20px"></div>
                        @else
                            <div class="alert alert-success">{{ __('pages.charat') }} <input type="checkbox" class="form-control" name="check_badges_group" value="on" style="height: 20px"></div>
                        @endif

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($activity_badges === 'on')
                                                    <input type="checkbox" checked="" name="activity_badges" value="on">
                                                @else
                                                    <input type="checkbox" name="activity_badges" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-4 check">{{ __('pages.chart-active') }} ( 4,8,16,32,64,128,256,512 {{ __('pages.register') }})</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($learn_badges === 'on')
                                                    <input type="checkbox" checked="" name="learn_badges" value="on">
                                                @else
                                                    <input type="checkbox" name="learn_badges" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-4 check">{{ __('pages.chart-learn') }}(1,2,4,6,8,16,32,128 {{ __('pages.finsih-couese') }})</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($trust_badges === 'on')
                                                    <input type="checkbox" checked="" name="trust_badges" value="on">
                                                @else
                                                    <input type="checkbox" name="trust_badges" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-4 check">{{ __('pages.shart-mission') }} (1,2,4,6,8,16,32,128{{ __('pages.finish-mission') }})</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($complete_badges === 'on')
                                                    <input type="checkbox" checked="" name="complete_badges" value="on">
                                                @else
                                                    <input type="checkbox" name="complete_badges" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-4 check">{{ __('pages.finish-complete') }} (1,2,4,6,8,16,32,128{{ __('test-or') }} +9690)</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($check_levels_group === 'on')
                            <div class="alert alert-success">{{ __('pages.levels') }} <input type="checkbox" checked="" class="form-control" name="check_levels_group" value="on" style="height: 20px"></div>
                        @else
                            <div class="alert alert-success">{{ __('pages.levels') }} <input type="checkbox" class="form-control" name="check_levels_group" value="on" style="height: 20px"></div>
                        @endif

                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($check_upgrade_level_points === 'on')
                                                  <input type="checkbox" checked="" name="check_upgrade_level_points" value="on">
                                                @else
                                                  <input type="checkbox" name="check_upgrade_level_points" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check"> {{ __('pages.upload-level') }} </label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$upgrade_level_points}}" name="upgrade_level_points">
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.points') }}</span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($check_upgrade_level_courses === 'on')
                                                    <input type="checkbox" checked="" name="check_upgrade_level_courses" value="on">
                                                @else
                                                    <input type="checkbox" name="check_upgrade_level_courses" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">  {{ __('pages.upload-level') }} </label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$upgrade_level_courses}}" name="upgrade_level_courses">
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.complete-course') }}</span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($check_upgrade_level_badges === 'on')
                                                    <input type="checkbox" checked="" name="check_upgrade_level_badges" value="on">
                                                @else
                                                    <input type="checkbox" name="check_upgrade_level_badges" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.upload-level') }}</label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width: 140px">
                                                <input id="kt_touchspin_1" type="number" class="form-control" value="{{$upgrade_level_badges}}" name="upgrade_level_badges">
                                                <span class="input-group-btn input-group-append">
                                                    <span class="btn btn-secondary ">{{ __('pages.charat') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($council_group_of_pioneers === 'on')
                            <div class="alert alert-success">  {{ __('pages.group_of_pioneers') }} <input type="checkbox" class="form-control" checked="" name="council_group_of_pioneers" value="on" style="height: 20px"></div>
                        @else
                            <div class="alert alert-success"> {{ __('pages.group_of_pioneers') }} <input type="checkbox" class="form-control" name="council_group_of_pioneers" value="on" style="height: 20px"></div>
                        @endif

                        <div class="kt-widget5">
                            <div class="kt-widget5__item" >
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($show_points === 'on')
                                                    <input type="checkbox" checked="" name="show_points" value="on">
                                                  @else
                                                    <input type="checkbox" name="show_points" value="on">
                                                  @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.show-levels') }}</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($show_Logos === 'on')
                                                    <input type="checkbox" checked="" name="show_Logos" value="on">
                                                @else
                                                    <input type="checkbox" name="show_Logos" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.show-points') }}</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div>
                                                @if($show_courses === 'on')
                                                    <input type="checkbox" checked="" name="show_courses" value="on">
                                                @else
                                                    <input type="checkbox" name="show_courses" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.show-notification') }}</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

{{--                         <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                    <input type="checkbox" name="">
                                            </div>
                                            <label class="col-form-label col-sm-3 check">إظهار الدورات </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="kt-widget5">
                            <div class="kt-widget5__item">
                                <div class="kt-widget5__content">
                                    <div class="kt-widget5__pic">
                                    </div>
                                    <div class="kt-widget5__section" style="width: 100%">

                                        <div class="form-group row">
                                            <div >
                                                @if($show_certificates === 'on')
                                                    <input type="checkbox" checked="" name="show_certificates" value="on">
                                                @else
                                                    <input type="checkbox" name="show_certificates" value="on">
                                                @endif
                                            </div>
                                            <label class="col-form-label col-sm-3 check">{{ __('pages.show-seen') }}</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 style="border-bottom: 5px solid #ccc;margin-bottom: 25px"></h5>
                        {{-- ---------------------------- --}}
                        
                        <div class="col-sm-2 text-center">
                            <button type="submit" class="btn btn-success">{{ __('pages.save') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection


@section('script')

    <script>
        $(document).ready(function () {
            // configure your validation
            $("#kt_form_1").validate({
                rules: {
                    site_name: {
                        required: true,
                    },
                    site_disc: {
                        required: true,
                    },
                    out_side_baner: {
                        required: true,
                    },
                    in_side_baner: {
                        required: true
                    },
                },

                messages: {
                    site_name: "{{__('jsMessage.site_name')}}",
                    site_disc: "{{__('jsMessage.site_disc')}}",
                    out_side_baner: "{{__('jsMessage.out_side_baner')}}",
                    in_side_baner: "{{__('jsMessage.in_side_baner')}}",

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
