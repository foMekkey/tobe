

<a class="btn btn-sm btn-clean btn-icon btn-icon-md upload" title="تعديل" data-user="{{$user_id}}" data-view="{{$file_id}}" data-name="{{$file_name}}" data-toggle="modal" data-target="#exampleModal">
    <i class="la la-edit"></i>
</a>


<a class="btn btn-sm btn-clean btn-icon btn-icon-md destroy"  id="{{$file_id}}" data-token="{{ csrf_token() }}" data-route="{{ route('destroyfile', $file_id) }}">

    <i class="la la-trash-o"></i>
</a>


<a class="btn btn-sm btn-clean btn-icon btn-icon-md " href="{{ url(asset('uploads/') .'/'.$file ) }}" download="{{ $file_name }}">
    <i class="la la-cloud-download"></i>
</a>




@section('script')

    <script>
        $(document).ready(function (e) {

            $('#imageUploadForm').on('submit',(function(e) {
                console.log('mohamed');
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type:'POST',
                    url: "{{ url('files/postupdate') .'/'.$file_id }}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        console.log(data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }));

        });
    </script>
@endsection
