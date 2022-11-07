
<a  class="btn btn-sm btn-clean btn-icon btn-icon-md openModelEdit" data-toggle="modal" data-value="{{$id}}" data-name="{{$name}}" data-target="#kt_modal_1"  title="View">
    <i class="la la-edit"></i>
</a>


<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy"  id="{{$id}}" data-token="{{ csrf_token() }}" data-route="{{ route('destroyevents', $id) }}">

    <i class="la la-trash-o"></i>
</a>





