@extends('backend.layouts.app')

@section('style')
    <style>
        .fa-star,
        .fa-star-o {
            color: #FF7F00;
            margin-left: 2px;
        }
    </style>
@endsection

@section('content')
    @include('errors.messages')

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.missions-info') }}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <form action="{{ route('StudentMissionsAddReply', $mission->id) }}" method="post" id="kt_form_1"
                enctype="multipart/form-data">
                @csrf
                <div class="kt-portlet__body">
                    <div class="kt-form__content">
                        <div class="kt-alert m-alert--icon alert alert-danger kt-hidden" role="alert" id="kt_form_1_msg">
                            <div class="kt-alert__icon">
                                <i class="la la-warning"></i>
                            </div>
                            <div class="kt-alert__text">
                                &nbsp;{{ __('pages.missions_validation_msg') }}
                            </div>
                            <div class="kt-alert__close">
                                <button type="button" class="close" data-close="alert" aria-label="Close">
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.mission-title') }} </label>
                        <div class="col-lg-9 col-xl-9">{{ $mission->name ?? '' }}</div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.mission-desc') }} </label>
                        <div class="col-lg-9 col-xl-9">{!! nl2br($mission->desc ?? '') !!}</div>
                    </div>

                    @if ($mission->file)
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.mission-attached-file') }}
                            </label>
                            <div class="col-lg-9 col-xl-9">
                                <a href="{{ config('filesystems.disks.contabo.url') . '/' . $mission->file }}"
                                    download="">{{ __('pages.download') }}</a>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.instructor_name') }} </label>
                        <div class="col-lg-9 col-xl-9">{{ $mission->user->user_name ?? '' }}</div>
                    </div>

                    @if ($mission->period)
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.period') }} </label>
                            <div class="col-lg-9 col-xl-9">{{ $mission->period }}</div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.expire_date') }} </label>
                        <div class="col-lg-9 col-xl-9">{{ $mission->expire_date }}</div>
                    </div>

                    @if ($reply)
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.status-column') }} </label>
                            <div class="col-lg-9 col-xl-9">
                                @if ($reply && $reply->status == '2')
                                    تم الإنجاز
                                @else
                                    ينتظر المراجعة
                                @endif
                            </div>
                        </div>
                    @endif

                    @if (($reply && $reply->reply) || !$reply)
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.the-reply') }} </label>
                            <div class="col-lg-9 col-xl-9">
                                @if ($reply)
                                    {!! nl2br($reply->reply) !!}
                                @else
                                    <textarea class="form-control" id="reply" rows="5" name="reply"></textarea>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($reply && $reply->file)
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.reply-attachment-file') }}
                            </label>
                            <div class="col-lg-9 col-xl-9">
                                <a onclick="SaveToDisk('{{ config('filesystems.disks.contabo.url') . '/' . $reply->file }}','{{ config('filesystems.disks.contabo.url') . '/' . $reply->file }}')"
                                    href="#">{{ __('pages.download') }}</a>
                            </div>
                        </div>
                    @elseif (!$reply)
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.attached_file') }} </label>
                            <div class="col-lg-9 col-xl-9">
                                <input type="file" name="file" id="file" class="form-control">
                            </div>
                        </div>
                    @endif

                    @if ($reply)
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.sent_at') }} </label>
                            <div class="col-lg-9 col-xl-9">
                                {{ $reply->sent_at ? \Carbon\Carbon::parse($reply->sent_at)->format('Y/m/d h:i a') : '' }}
                            </div>
                        </div>

                        @if ($reply->trainer_rate)
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.trainer_rate') }} </label>
                                <div class="col-lg-9 col-xl-9">
                                    @for ($i = 1; $i < 6; $i++)
                                        @if ($i <= $reply->trainer_rate)
                                            <span class="fa fa-star"></span>
                                        @else
                                            <span class="fa fa-star-o"></span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        @endif

                        @if ($reply->trainer_comment)
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.comment') }} </label>
                                <div class="col-lg-9 col-xl-9">
                                    {!! nl2br($reply->trainer_comment) !!}
                                </div>
                            </div>
                        @endif
                    @endif

                    @if (!$reply)
                        <div class="kt-form__actions">
                            <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                type="submit">
                                {{ __('pages.reply_send') }}
                            </button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    reply: {
                        required: function(element) {
                            return !$("#file").val();
                        }
                    },
                    file: {
                        required: function(element) {
                            return !$("#reply").val();
                        }
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

        function SaveToDisk(fileURL, fileName) {
            // for non-IE
            if (!window.ActiveXObject) {
                var save = document.createElement('a');
                save.href = fileURL;
                save.target = '_blank';
                save.download = fileName || 'unknown';

                var evt = new MouseEvent('click', {
                    'view': window,
                    'bubbles': true,
                    'cancelable': false
                });
                save.dispatchEvent(evt);

                (window.URL || window.webkitURL).revokeObjectURL(save.href);
            }

            // for IE < 11
            else if (!!window.ActiveXObject && document.execCommand) {
                var _window = window.open(fileURL, '_blank');
                _window.document.close();
                _window.document.execCommand('SaveAs', true, fileName || fileURL)
                _window.close();
            }
            return false;
        }
    </script>
@endsection
