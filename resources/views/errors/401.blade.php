@extends('errors.layout')

@section('error-icon', 'fa-user-times')
@section('error-code', '401')
@section('error-title', __('site.unauthorized'))
@section('error-description', __('site.unauthorized_message'))
