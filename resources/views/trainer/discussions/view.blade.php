@extends('backend.layouts.app')
@section('style')
    <style>
        .slidecontainer {
            width: 100%;
        }

        .slider {
            -webkit-appearance: none;
            width: 100%;
            height: 25px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            background: #4CAF50;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            height: 25px;
            background: #4CAF50;
            cursor: pointer;
        }

        .comments-earea .row {
            margin: 0;
            margin-bottom: 15px;
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
                        <form class="kt-form kt-form--label-right" id="kt_form_1">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$discussion->id}}">
                        <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content"
                                 data-ktwizard-state="current">
{{--                                 <div class="kt-portlet__head kt-portlet__head--lg" style="">
                                    <div class="kt-portlet__head-label">
                                        <h2 class="kt-portlet__head-title">{{ __('pages.edit-discussion') }} : {{$discussion->title}}</h2>
                                    </div>
                                </div> --}}

                                <div class="kt-section kt-section--first">
                                    <div class="kt-wizard-v4__form">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">

                                                {{-- contetn --}}
                                                 <div class="form-group row">
                                                    <label class="col-xl-2 col-lg-2 col-form-label">  
                                                    </label>

                                                     <div class="col-lg-10 col-xl-10">
                                                         <div class="form-group row" style="border: 1px solid #ccc;height: 179px;padding: 14px;border-radius: 10px;margin: 0;">
                                                             <div class="col-lg-6 col-xl-12">
                                                                 <div class="form-group row">
                                                                     <div class="col-lg-4 col-xl-4">{{$discussion->title}}</div>
                                                                     <div class="col-lg-4 col-xl-4">{{$discussion->User->f_name}}</div>
                                                                     <div class="col-lg-4 col-xl-4">{{$discussion->created_at}}</div>
                                                                 </div>
                                                             </div>
                                                             <div class="col-lg-6 col-xl-12">{{$discussion->body}}</div>
                                                         </div>
                                                     </div>
                                                 </div>

                                                 <div class="comments-earea">
                                                @foreach($discussion->Comments as $comment)
                                                    <div class="form-group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">  
                                                        </label>

                                                        <div class="col-lg-10 col-xl-10" style="border: 1px solid #087b78;border-radius: 8px;background: whitesmoke;">
                                                            <div class="form-group row">
                                                                <div class="col-lg-12 col-xl-12">
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-6 col-xl-6">{{$comment->User->f_name}}</div>
                                                                        <div class="col-lg-6 col-xl-6">{{$comment->created_at}}</div>
                                                                        <div class="col-lg-12 col-xl-12" style="margin-top: 10px">
                                                                            {{$comment->comment}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                 @endforeach
                                                 </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-2 col-lg-2 col-form-label">  {{-- {{ __('pages.message') }}  
                                                    <span style="color: red">*</span> --}} </label>
                                                    <div class="col-lg-10 col-xl-10">
                                                    <textarea class="form-control" name="body" id="discussion_comment" placeholder="{{ __('pages.reply') }}" rows="1" spellcheck="false" required=""></textarea></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-2 col-lg-2 col-form-label"> 
                                                    </label>
                                                    <div class="col-lg-10 col-xl-10 ">
                                                        <button class="btn add_comment btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                                                type="button" style="display: none">
                                                            {{ __('pages.reply') }}
                                                        </button>                                                        
                                                    </div>
                                                </div>

{{--                                                     <div class="form-group row">
                                                    <label class="col-form-label col-lg-3 col-xl-3">{{ __('pages.choose-attachment') }}</label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input class="form-control" name="attachment" type="file" >
                                                    </div>
                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!--end: Form Wizard Step 1-->

                            <!--begin: Form Actions -->
{{--                             <div class="kt-form__actions">



                            </div> --}}

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

    <script>


        $.fn.datepicker.dates['ar'] = {
            days: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"],
            daysShort: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت", "أحد"],
            daysMin: ["ح", "ن", "ث", "ع", "خ", "ج", "س", "ح"],
            months: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
            monthsShort: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
            today: "هذا اليوم",
            rtl: true
        };
        $('#datepickerr').datepicker({
            language: 'ar',
            format: "mm/dd/yyyy",

        });

        // add comment
        $(document).on('click','.add_comment',function(){
            var comment = $('#discussion_comment').val();

            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': '{{csrf_field()}}'
              }
            });

            $.ajax({
              url: "{{ url('trainer/discussions/add-comment') }}" + '/' + '{{Auth::user()->id}}' + '/' + comment + '/' + '{{$discussion->id}}' ,
              method: 'get',
              success: function(result){
                console.log(result)
                if(result.status === '1' )
                {
                    $('.comments-earea').append(`
                        <div class="form-group row">
                        <label class="col-xl-2 col-lg-2 col-form-label">  
                        </label>

                        <div class="col-lg-10 col-xl-10" style="border: 1px solid #087b78;border-radius: 8px;background: whitesmoke;">
                            <div class="form-group row">
                                <div class="col-lg-12 col-xl-12">
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-xl-6">{{Auth::user()->f_name}}</div>
                                        <div class="col-lg-6 col-xl-6">${result.data.created_at}</div>
                                        <div class="col-lg-12 col-xl-12" style="margin-top: 10px">
                                            ${result.data.comment}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    `)
                    $('#discussion_comment').val('');
                }
              }
            });
        });

        $(document).ready(function () {
            $('#discussion_comment').focus(function(){
                $(this).attr('rows',7);
                $('.add_comment').show();
            }).blur(function(){
                if (!$('#discussion_comment').val()) {
                    $(this).attr('rows',1);
                    $('.add_comment').hide();
                }
            });
        });
    </script>
@endsection
