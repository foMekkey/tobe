<div class='btn-group'>
    <a href="{{ route('registrations.show', $id) }}" class='btn btn-default btn-sm'>
        <i class="fa fa-eye"></i>
    </a>

    @if ($status == 'pending')
        <a href="{{ route('registrations.approve', $id) }}" class='btn btn-success btn-sm'
            onclick="return confirm('هل أنت متأكد من قبول هذا الطلب؟')">
            <i class="fa fa-check"></i>
        </a>

        <button type="button" class='btn btn-danger btn-sm reject-btn' data-id="{{ $id }}">
            <i class="fa fa-times"></i>
        </button>
    @endif
</div>
