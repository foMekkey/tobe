@extends('backend.layouts.app')

@section('page-main-title', __('pages.courses'))

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('StudentCourses')}}">{{ __('pages.home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ route('showCourseDetailsStudent',['id'=>$courses_lesson->course_id]) }}">{{ $courses_lesson->course->name}}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $courses_lesson->name }}</li>
        </ol>
    </nav>

    <div class="message">
    </div>

    @include('errors.messages')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-font-brand flaticon2-line-chart"></i>
					</span>
                <h3 class="kt-portlet__head-title">
                    {{ $courses_lesson->name }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <div class="dropdown dropdown-inline">
                        </div>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                @if($courses_lesson->type == 1 && $courses_lesson->file)
                    <iframe width="100%" height="600" src="{{ asset('uploads/'.$courses_lesson->file) }}"></iframe>
                @elseif($courses_lesson->type == 2 && $courses_lesson->file)
                    <a href="{{ asset('uploads/'.$courses_lesson->file) }}" class="btn btn-brand btn-success btn-icon-sm" target="_blank">
                        {{ __('pages.download') }}
                    </a>
                @else
                    {!! $courses_lesson->content !!}
                @endif
            </div>
            <hr>
            <div class="row">
                @if(empty($courseUserLog->status))
                <a id="finish_lesson" href="#" class="btn btn-brand btn-elevate btn-icon-sm">
                    {{ __('pages.finsih') }}
                </a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#finish_lesson').click(function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('finishLessonStudent') }}",
                data: {'_token': "{{ csrf_token() }}", 'id': {{ $courses_lesson->id}}, 'course_id': {{ $courses_lesson->course_id}} },
                success: function (msg) {
                    $('#finish_lesson').hide();
                }
            });
        });
    </script>
@endsection