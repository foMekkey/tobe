@extends('backend.layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('site_assets') }}/css/star-rating-svg.css">
    <style>
        .my-rating {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    @include('errors.messages')

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.missions-show-reply') }}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <form action="{{ route('TrainerMissionsUpdateReply', ['id' => $reply->id]) }}" method="post" id="kt_form_1">
                @csrf
                <div class="kt-portlet__body">
                    <div class="kt-form__content">
                        <div class="kt-alert m-alert--icon alert alert-danger kt-hidden" role="alert" id="kt_form_1_msg">
                            <div class="kt-alert__icon">
                                <i class="la la-warning"></i>
                            </div>
                            <div class="kt-alert__text">
                                &nbsp;{{ __('pages.please_fill_required_fields') }}
                            </div>
                            <div class="kt-alert__close">
                                <button type="button" class="close" data-close="alert" aria-label="Close">
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.mission-title') }} </label>
                        <div class="col-lg-9 col-xl-9">{{ $reply->mission->name ?? '' }}</div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.mission-desc') }} </label>
                        <div class="col-lg-9 col-xl-9">{!! nl2br($reply->mission->desc ?? '') !!}</div>
                    </div>

                    @if ($reply->mission->file)
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.mission-attached-file') }}
                            </label>
                            <div class="col-lg-9 col-xl-9">
                                <a href="{{ config('filesystems.disks.contabo.url') . '/' . $reply->mission->file }}"
                                    download="">{{ __('pages.download') }}</a>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.Student') }} </label>
                        <div class="col-lg-9 col-xl-9">{{ $reply->user->user_name ?? '' }}</div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.the-reply') }} </label>
                        <div class="col-lg-9 col-xl-9">{!! nl2br($reply->reply) !!}</div>
                    </div>

                    @if ($reply->file)
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.reply-attachment-file') }}
                            </label>
                            <div class="col-lg-9 col-xl-9">
                                <a href="{{ url('downloader/file?filename=' . config('filesystems.disks.contabo.url') . '/' . $reply->file) }}"
                                    download="">{{ __('pages.download') }}</a>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.sent_at') }} </label>
                        <div class="col-lg-9 col-xl-9">
                            {{ $reply->sent_at ? \Carbon\Carbon::parse($reply->sent_at)->format('Y/m/d h:i a') : '' }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.status-column') }} <span
                                style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control" name="status">
                                <option value="1" @if ($reply->status == '1') selected @endif> ينتظر المراجعة
                                </option>
                                <option value="2" @if ($reply->status == '2') selected @endif> تم الإنجاز
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.trainer_rate') }} <span
                                style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <div class="my-rating"></div>
                            <input name="trainer_rate" value="{{ $reply->trainer_rate ? $reply->trainer_rate : '' }}"
                                id="add_review-rate" style="width: 0; border: none" tabindex="-1" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.comment') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea name="trainer_comment" class="form-control" rows="5">{{ $reply->trainer_comment ? $reply->trainer_comment : '' }}</textarea>
                        </div>
                    </div>

                    <div class="kt-form__actions">
                        <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                            type="submit">
                            {{ __('pages.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('site_assets') }}/js/jquery.star-rating-svg.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".my-rating").starRating({
                initialRating: {{ $reply->trainer_rate ? $reply->trainer_rate : 0 }},
                strokeColor: '#FF7F00',
                starShape: 'rounded',
                useFullStars: true,
                strokeWidth: 0,
                starSize: 20,
                disableAfterRate: false,
                callback: function(currentRating, $el) {
                    $('#add_review-rate').val(currentRating);
                    $('#add_review-rate').removeClass('error');
                    $('#add_review-rate').closest('.form-group').find('label.error').remove();
                }
            });

            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    trainer_rate: {
                        required: true,
                    },
                    status: {
                        required: true,
                    }
                },
                //display error alert on form submit
                invalidHandler: function(event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt-hidden').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },
            });
        });
    </script>
@endsection
