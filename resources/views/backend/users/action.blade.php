
<a href="{{ url('users/edit/'.$id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
    <i class="la la-edit"></i>
</a>

<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy"  id="{{$id}}" data-token="{{ csrf_token() }}" data-route="{{ route('destroyuser', $id) }}">

    <i class="la la-trash-o"></i>
</a>

@if ($role == 3)
<a data-toggle="modal" data-target="#AddEventModel" data-rel="{{ $id }}" class="btn btn-sm btn-clean btn-icon btn-icon-md add_event" title="اضافة حدث">
    <i class="la la-calendar"></i>
</a>
@endif