@if($user_id == auth()->user()->id)
<a href="{{ url('trainer/discussions/edit/'.$id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
    <i class="la la-edit"></i>
</a>

<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy"  id="{{$id}}" data-token="{{ csrf_token() }}" data-route="{{ route('destroydiscussionTrainer', $id) }}">

    <i class="la la-trash-o"></i>
</a>
@endif

<a href="{{ url('trainer/discussions/show/'.$id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
    <i class="la la-eye"></i>
</a>
