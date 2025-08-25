@extends('backend.layouts.app')
@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <style>
        .bootstrap-tagsinput {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            display: block;
            padding: 4px 6px;
            color: #555;
            vertical-align: middle;
            border-radius: 4px;
            max-width: 100%;
            line-height: 22px;
            cursor: text;
        }

        .bootstrap-tagsinput input {
            border: none;
            box-shadow: none;
            outline: none;
            background-color: transparent;
            padding: 0 6px;
            margin: 0;
            width: auto;
            max-width: inherit;
        }

        .label-info {
            background-color: #5bc0de;
            padding: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="kt-wizard-v4" id="kt_apps_user_add_user" data-ktwizard-state="step-first">

        @include('errors.messages')
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        تعديل الفوج: {{ $cohort->name }}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                {!! Form::model($cohort, [
                    'route' => ['cohorts.update', $cohort->id],
                    'method' => 'post',
                    'class' => 'kt-form kt-form--label-right',
                    'files' => true,
                ]) !!}
                @include('admin.cohorts.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
