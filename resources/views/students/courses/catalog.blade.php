@extends('backend.layouts.app')
@section('page-main-title', __('pages.courses'))
@section('page-main-url', route('StudentCourses'))

@section('style')
    <style>
        .kt-widget5__item .img-fluid {
            max-height: 120px;
        }
    </style>
@append

@section('content')

    <div class="message"></div>

    @include('errors.messages')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">

            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-line-chart"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.courses_catalog') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <div class="dropdown dropdown-inline">
                            <select class="form-control" id="category_id">
                                <option value="">{{ __('pages.all_categories') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($categoryId == $category->id) selected @endif>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="col-xl-12">
                <div class="kt-widget5">
                    @foreach ($courses as $course)
                        <div class="kt-widget5__item">
                            <div class="col-md-12">
                                <div class="col-md-2 pull-right text-center">
                                    <img class="img-fluid"
                                        src="{{ config('filesystems.disks.contabo.url') . '/' . $course->image }}"
                                        alt="">
                                </div>
                                <div class="col-md-8 pull-right">
                                    <a href="{{ route('showCourseDetailsStudent', $course->id) }}"
                                        class="kt-widget5__title">
                                        <h3>{{ $course->name }}</h3>
                                    </a>
                                    <div class="kt-widget5__info">
                                        <span class="kt-font-info">{{ $course->category->name ?? '' }}</span>
                                    </div>
                                    <p class="kt-widget5__desc">
                                        {!! $course->desc !!}
                                    </p>
                                </div>
                                <div class="col-md-2 pull-right">
                                    @if (in_array($course->id, $userCourses))
                                        <a href="#"
                                            class="btn btn-default disabled pull-left">{{ __('pages.you_have_this_course') }}</a>
                                    @else
                                        <a href="{{ url('/student/courses/catalog/' . $course->id) }}"
                                            class="btn btn-brand btn-elevate join_course pull-left">{{ __('pages.got_course') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#category_id').change(function() {
            location.href = "{{ route('StudentCatalog') }}/" + $(this).val();
        });
    </script>
@endsection
