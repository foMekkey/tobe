
<a class="btn btn-sm btn-clean btn-icon btn-icon-md upload" title="تعديل" data-group="{{$id_group}}" data-view="{{$file_id}}" data-name="{{$file_name}}" data-toggle="modal" data-target="#exampleModal">
    <i class="la la-edit"></i>
</a>


<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy"  id="{{$file_id}}" data-token="{{ csrf_token() }}" data-route="{{ route('destroyfile', $file_id) }}">

    <i class="la la-trash-o"></i>
</a>


<a class="btn btn-sm btn-clean btn-icon btn-icon-md " href="{{ url(asset('uploads/') .'/'.$file ) }}" download="{{ $file_name }}">
    <i class="la la-cloud-download"></i>
</a>






