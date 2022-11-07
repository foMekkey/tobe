
<a href="{{ url('trainer/meeting/edit/'.$id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
    <i class="la la-edit"></i>
</a>

<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy"  id="{{$id}}" data-token="{{ csrf_token() }}" data-route="{{ route('destroymeetingTrainer', $id) }}">

    <i class="la la-trash-o"></i>
</a>

@php
    $isRunning = 0;
    if ($date && $time && $period) {
        $currentTime = Carbon\Carbon::now();
        $diff = $currentTime->diffInMinutes(Carbon\Carbon::parse($date . ' ' . $time));
        if ($diff >= 0 && $diff < $period) {
            $isRunning = 1;
        }
    }
@endphp

@if($isRunning)
    <a href="{{ url('trainer/meeting/start/'.$id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Start meeting" target="_blank">
        <i class="la la-play"></i>
    </a>
@endif
