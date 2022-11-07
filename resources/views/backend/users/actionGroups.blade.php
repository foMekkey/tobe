@if(checkPermission('destroyGroupFromList'))

    <a href="{{ url('users/destroy-groupFrom-List/'.$user_id .'/'.$group_id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="الغاء الالتحاق">
       <i class="flaticon2-delete"></i>
    </a>

@endif






