@extends('backend.layouts.app')
@section('page-main-title', __('pages.courses'))
@section('page-main-url', route('StudentCourses') )

@section('content')

    <div class="message"></div>

    @include('errors.messages')

    {{--<div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">

            <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-font-brand flaticon2-line-chart"></i>
					</span>
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.courses') }}
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
            <div class="col-xl-12"> --}}

                <div class="kt-portlet">
                    <div class="kt-portlet__body  kt-portlet__body--fit">
                        <div class="row row-no-padding row-col-separator-lg">

                            <div class="col-md-12 col-lg-6 col-xl-3">
                                <!--begin::Total Profit-->
                                <div class="kt-widget24">
                                    <div class="kt-widget24__details">
                                        <div class="kt-widget24__info">
                                            <h4 class="kt-widget24__title">
                                                عدد النقاط
                                            </h4>
                                        </div>
                                        <span class="kt-widget24__stats kt-font-brand">
                                            <span class="kt-badge kt-badge--primary kt-badge--xl">{{ auth()->user()->points ? auth()->user()->points : 0 }}</span>
                                        </span>
                                    </div>
                                </div>
                                <!--end::Total Profit-->
                            </div>

                            <div class="col-md-12 col-lg-6 col-xl-3">
                                <!--begin::New Feedbacks-->
                                <div class="kt-widget24">
                                    <div class="kt-widget24__details">
                                        <div class="kt-widget24__info">
                                            <h4 class="kt-widget24__title">
                                                الدورات الجارية
                                            </h4>
                                        </div>
                                        <span class="kt-widget24__stats kt-font-warning">
                                           <span class="kt-badge kt-badge--warning kt-badge--xl">{{ $coursesInProgress }}</span>
                                        </span>
                                    </div>
                                </div>
                                <!--end::New Feedbacks-->
                            </div>
                            <div class="col-md-12 col-lg-6 col-xl-3">
                                <!--begin::New Users-->
                                <div class="kt-widget24">
                                    <div class="kt-widget24__details">
                                        <div class="kt-widget24__info">
                                            <h4 class="kt-widget24__title">
                                                الدورات المكتملة
                                            </h4>
                                        </div>
                                        <span class="kt-widget24__stats kt-font-success">
                                            <span class="kt-badge kt-badge--success kt-badge--xl">{{ $coursesCompleted }}</span>
                                        </span>
                                    </div>
                                </div>
                                <!--end::New Users-->
                            </div>
                            <div class="col-md-12 col-lg-6 col-xl-3">
                                <!--begin::New Users-->
                                <div class="kt-widget24">
                                    <div class="kt-widget24__details">
                                        <div class="kt-widget24__info">
                                            <h4 class="kt-widget24__title">
                                                عدد الساعات
                                            </h4>
                                        </div>
                                        <span class="kt-widget24__stats kt-font-success">
                                            <span class="kt-badge kt-badge--dark kt-badge--xl">{{ $coursesCompletedDurations }}</span>
                                        </span>
                                    </div>
                                </div>
                                <!--end::New Users-->
                            </div>
                        </div>
                    </div>
                </div>

                <!--begin:: Widgets/Best Sellers-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--lg">

                        <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                </span>
                            <h3 class="kt-portlet__head-title">
                                الدورات المشترك بها
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
                        <div class="tab-content">
                            <div class="tab-pane active" id="kt_widget5_tab1_content" aria-expanded="true">
                                <div class="row">
                                    @foreach($courses as $course)
                                        <div class="col-xl-6">
                                            <!--begin:: Portlet-->
                                            <div class="kt-portlet kt-portlet--height-fluid">
                                                <div class="kt-portlet__body kt-portlet__body--fit">
                                                    <!--begin::Widget -->
                                                    <div class="kt-widget kt-widget--project-1">
                                                        <div class="kt-widget__head">
                                                            <div class="kt-widget__label">
                                                                <div class="kt-widget__media">
                                                                    <span class="kt-media kt-media--lg kt-media--circle">
                                                                        <img src="{{ config("filesystems.disks.contabo.url").'/'.$course['Courses']['image'] }}" alt="image">
                                                                    </span>
                                                                </div>
                                                                <div class="kt-widget__info kt-margin-t-5">
                                                                    <a href="{{ route('showCourseDetailsStudent',['id'=>$course['Courses']['id']]) }}" class="kt-widget__title">
                                                                        {{ $course['Courses']['name'] }}
                                                                    </a>
                                                                    <span class="kt-widget__desc">
                                                                        <span>{{__('pages.author')}} : </span>
                                                                        <span class="kt-font-info">{{ \App\User::NameTrainer($course['Courses']['user_id']) }}</span>
                                                                        <span class="ml-3">{{__('pages.end_date')}} : </span>
                                                                        <span class="kt-font-info"> {{ $course['Courses']['end_date'] }}</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="kt-widget__body">
                                                            <span class="kt-widget__text" style="margin-top: 0">
                                                                {{ $course['Courses']['desc'] }}
                                                            </span>
                                                            <div class="kt-widget__stats">
                                                                <div class="kt-widget__item flex-fill">
                                                                    <span class="kt-widget__subtitel">التقدم</span>
                                                                    <div class="kt-widget__progress d-flex  align-items-center">
                                                                        <div class="progress" style="height: 5px;width: 100%;">
                                                                            <div class="progress-bar @if($course->progress_percentage == 100)kt-bg-success @else kt-bg-warning @endif" role="progressbar" style="width: {{ $course->progress_percentage }}%;" aria-valuenow="{{ $course->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                        <span class="kt-widget__stat">
                                                                            {{ $course->progress_percentage }}%
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Widget -->
                                                </div>
                                            </div>
                                            <!--end:: Portlet-->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="kt-portlet__head kt-portlet__head--lg">

                        <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                </span>
                            <h3 class="kt-portlet__head-title">
                                الدورات الخاصة بالمجموعات المشترك بها
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
                        <div class="tab-content">
                            <div class="tab-pane active" id="kt_widget5_tab1_content" aria-expanded="true">
                                <div class="row">
                                    @foreach($groupCourses as $course)
                                        <div class="col-xl-6">
                                            <!--begin:: Portlet-->
                                            <div class="kt-portlet kt-portlet--height-fluid">
                                                <div class="kt-portlet__body kt-portlet__body--fit">
                                                    <!--begin::Widget -->
                                                    <div class="kt-widget kt-widget--project-1">
                                                        <div class="kt-widget__head">
                                                            <div class="kt-widget__label">
                                                                <div class="kt-widget__media">
                                                                    <span class="kt-media kt-media--lg kt-media--circle">
                                                                        <img src="{{ asset('/uploads/'.$course['image']) }}" alt="image">
                                                                    </span>
                                                                </div>
                                                                <div class="kt-widget__info kt-margin-t-5">
                                                                    <a href="{{ route('showCourseDetailsStudent',['id'=>$course['id']]) }}" class="kt-widget__title">
                                                                        {{ $course['name'] }}
                                                                    </a>
                                                                    <span class="kt-widget__desc">
                                                                        <span>{{__('pages.author')}} : </span>
                                                                        <span class="kt-font-info">{{ \App\User::NameTrainer($course['user_id']) }}</span>
                                                                        <span class="ml-3">{{__('pages.end_date')}} : </span>
                                                                        <span class="kt-font-info"> {{ $course['end_date'] }}</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="kt-widget__body">
                                                            <span class="kt-widget__text" style="margin-top: 0">
                                                                {{ $course['desc'] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!--end::Widget -->
                                                </div>
                                            </div>
                                            <!--end:: Portlet-->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:: Widgets/Best Sellers-->
            {{-- </div>
        </div>
    </div> --}}
@endsection

