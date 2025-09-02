@extends('site.layouts.app')

@section('styles')
    <link href="{{ asset('site_assets/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="inner_banner">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>تعديل المنشور</h1>
                <h3>{{ $community->name }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ route('community.index') }}">{{ __('site.communities') }}</a></li>
                <li><a href="{{ route('community.show', $community->id) }}">{{ $community->name }}</a></li>
                <li><a href="#">تعديل المنشور</a></li>
            </ul>
        </div>
    </section>

    <section class="edit-post-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="edit-post-card">
                        <div class="edit-post-header">
                            <h3>تعديل المنشور</h3>
                        </div>
                        <form action="{{ route('community.post.update', $post->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="edit-post-body">
                                <div class="form-group">
                                    <label for="content">محتوى المنشور</label>
                                    <textarea class="form-control" id="content" name="content" rows="5" required>{{ $post->content }}</textarea>
                                    @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if ($post->media)
                                    <div class="form-group">
                                        <label>الصورة الحالية</label>
                                        <div class="current-media">
                                            <img src="{{ asset('uploads/community/' . $post->media) }}" alt="صورة المنشور">
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="media">تغيير الصورة (اختياري)</label>
                                    <input type="file" class="form-control" id="media" name="media"
                                        accept="image/*">
                                    @error('media')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if ($post->media)
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remove_media"> إزالة الصورة الحالية
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="edit-post-footer">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                <a href="{{ route('community.show', $community->id) }}" class="btn btn-default">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
