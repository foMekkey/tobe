<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy" id="{{ $id }}" data-token="{{ csrf_token() }}"
    data-route="{{ route('DeleteNewslettersSubscription', $id) }}">

    <i class="la la-trash-o"></i>
</a>
