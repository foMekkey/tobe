<a href="{{ route('cohorts.show', $id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="عرض">
    <i class="la la-eye"></i>
</a>

<a href="{{ route('cohorts.edit', $id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="تعديل">
    <i class="la la-edit"></i>
</a>

<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy" id="{{ $id }}" data-token="{{ csrf_token() }}"
    data-route="{{ route('cohorts.destroy', $id) }}" title="حذف">
    <i class="la la-trash-o"></i>
</a>
