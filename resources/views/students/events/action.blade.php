
<a href="{{ url('trainer/meeting/edit/'.$id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
    <i class="la la-edit"></i>
</a>

<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy"  id="{{$id}}" data-token="{{ csrf_token() }}" data-route="{{ route('destroymeetingTrainer', $id) }}">

    <i class="la la-trash-o"></i>
</a>
