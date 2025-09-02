@extends('site.layouts.app')

@section('styles')
    <link href="{{ asset('site_assets/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="inner_banner">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>تعديل التعليق</h1>
                <h3>{{ $community->name }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ route('community.index') }}">{{ __('site.communities') }}</a></li>
                <li><a href="{{ route('community.show', $community->id) }}">{{ $community->name }}</a></li>
                <li><a href="#">تعديل التعليق</a></li>
            </ul>
        </div>
    </section>

    <section class="edit-comment-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="edit-comment-card">
                        <div class="edit-comment-header">
                            <h3>تعديل التعليق</h3>
                        </div>
                        <form action="{{ route('community.comment.update', $comment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="edit-comment-body">
                                <div class="form-group">
                                    <label for="content">محتوى التعليق</label>
                                    <textarea class="form-control" id="content" name="content" rows="3" required>{{ $comment->content }}</textarea>
                                    @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="edit-comment-footer">
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
