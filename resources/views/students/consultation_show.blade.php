@extends('backend.layouts.app')

@section('style')
    <style>
        .fa-star, .fa-star-o {
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
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.date') }} </label>
                    <div class="col-lg-9 col-xl-9">{{ $consultation->date }}</div>
                </div>

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.hours') }} </label>
                    <div class="col-lg-9 col-xl-9">{{ $consultation->hours }}</div>
                </div>

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.session_type') }} </label>
                    <div class="col-lg-9 col-xl-9">
                        @if ($consultation->session_type == 1)
                            {{ __('pages.direct') }}
                        @else
                            {{ __('pages.remotely') }}
                        @endif
                    </div>
                </div>

                @if ($consultation->file)
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.attached-file') }} </label>
                        <div class="col-lg-9 col-xl-9">
                            <a href="{{ asset("uploads/".$consultation->file) }}" download="">{{ __('pages.download') }}</a>
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.subject') }} </label>
                    <div class="col-lg-9 col-xl-9">{{ $consultation->subject }}</div>
                </div>

                @if ($consultation->status == 2 && !empty($consultation->suggested_date))
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.suggested_date') }} </label>
                        <div class="col-lg-9 col-xl-9">{{ $consultation->suggested_date }}</div>
                    </div>

                    <div class="kt-form__actions">
                        <button class="btn btn-success btn-md kt-font-bold kt-font-transform-u suggested_date_action" rel="accept">
                            {{ __('pages.accept_suggested_date') }}
                        </button>
                        <button class="btn btn-danger btn-md kt-font-bold kt-font-transform-u ml-2 suggested_date_action" rel="reject">
                            {{ __('pages.reject_suggested_date') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.suggested_date_action').click(function() {
                var action = $(this).attr('rel');
                
                $.ajax({
                    type: "POST",
                    url: "{{ url('consultations/suggested_date_action') }}",
                    data: {'_token': "{{ csrf_token() }}", 'id': {{ $consultation->id }}, 'action': action},
                    dataType: "json",
                    success: function (msg) {
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
