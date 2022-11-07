@extends('backend.layouts.app')

@section('content')
    @include('errors.messages')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-font-brand flaticon2-line-chart"></i>
					</span>
                <h3 class="kt-portlet__head-title">
                    {{ $lesson->name }}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            @if($lesson->type == 2)
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ asset('uploads/'.$lesson->content) }}" allowfullscreen></iframe>
                </div>
            @else
                {!! $lesson->content !!}
            @endif
        </div>
        <!--end::Portlet-->
    </div>
@endsection