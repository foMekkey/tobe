<a href="{{ route('editsurveys', ['courseId' => $course_id, 'id' => $id]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="{{ __('pages.edit') }}">
    <i class="la la-edit"></i>
</a>

@if(Carbon\Carbon::today()->format('Y-m-d') >= $date)
<a href="{{ route('SurveysResults', ['courseId' => $course_id, 'id' => $id]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="{{ __('pages.surveys-results-short') }}">
    <i class="la la-bar-chart"></i>
</a>
@endif