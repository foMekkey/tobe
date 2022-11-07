@extends('backend.layouts.app')

@section('style')
    <style>
        .mt-radio-list .mt-radio, .mt-radio>input:checked~span:after {
            display: block;
        }
        .card {
            margin-bottom: 10px;
        }
        .kt-portlet .kt-portlet__body {
            font-size: 16px;
        }
        .card-header {
            font-weight: bold;
        }
        .error {
            color: #f00000;
        }
    </style>
@endsection

@section('content')
    @include('errors.messages')

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ $survey->title }}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            @if ($surveyAnswerExists)
                <div class="alert alert-success fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                    <div class="alert-text " id="swalalert">{{ __('pages.survey-error-already-answered') }}</div>
                </div>
            @else
                <form action="{{ route('answerSurveysStudent', $survey->id) }}" method="post" id="kt_form_1">
            @endif
                <div class="kt-form__content">
                    <div class="kt-alert m-alert--icon alert alert-danger kt-hidden" role="alert" id="kt_form_1_msg">
                        <div class="kt-alert__icon">
                            <i class="la la-warning"></i>
                        </div>
                        <div class="kt-alert__text">
                            &nbsp;{{ __('pages.survey_validation_msg') }}
                        </div>
                        <div class="kt-alert__close">
                            <button type="button" class="close" data-close="alert" aria-label="Close">
                            </button>
                        </div>
                    </div>
                </div>

                @php $rules = ''; @endphp
                @foreach ($questions as $question)
                    <div class="card">
                        <div class="card-header">{{ $question->question }} @if($question->is_required) <span style="color: red">*</span> @endif</div>
                        <div class="card-body">
                            @if ($question->type == 1)
                                <input type="text" class="form-control" name="questions[{{ $question->id }}]" value="" />
                            @elseif ($question->type == 2 && $question->allowed_options && !$survey->is_day_star)
                                @php $allowedOptions = explode("\r\n", $question->allowed_options); @endphp
                                <div class="mt-radio-list">
                                    @foreach ($allowedOptions as $option)
                                        <label class="mt-radio mt-radio-outline">
                                            <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option }}"> {{ $option }}
                                            <span></span>
                                        </label>
                                    @endforeach
                                </div>
                            @elseif ($question->type == 2 && $survey->is_day_star)
                                <div class="mt-radio-list">
                                    @foreach ($courseUsers as $courseUser)
                                        <label class="mt-radio mt-radio-outline">
                                            <input type="radio" name="questions[{{ $question->id }}]" value="{{ $courseUser->user_id }}"> {{ $courseUser->user->user_name ?? '' }}
                                            <span></span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @php if($question->is_required){$rules .= '"questions[' . $question->id . ']": "required",';} @endphp
                    </div>
                @endforeach

                @if (!$surveyAnswerExists)
                    <div class="kt-form__actions">
                        @csrf
                        <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                            {{ __('pages.reply_send') }}
                        </button>
                    </div>
                </form>
                @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    {!! $rules !!}
                },
                errorPlacement: function(error, element) {
                    var elem = $(element);
                    error.insertBefore(element);
                },
                //display error alert on form submit
                invalidHandler: function (event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt-hidden').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },
            });
            
            $.validator.messages.required = '{{ __("pages.question-is-required") }}';
        });
    </script>
@endsection
