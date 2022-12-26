<a href="{{ url('courses/show-all/'.$id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="عرض">
    <i class="la la-code"></i>
</a>

<a href="{{ url('courses/edit/'.$id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
    <i class="la la-edit"></i>
</a>

<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy"  id="{{$id}}" data-token="{{ csrf_token() }}" href="{{ route('destroycourses', $id) }}">
    <i class="la la-trash-o"></i>
</a>