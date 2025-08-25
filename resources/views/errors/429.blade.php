@extends('errors.layout')

@section('error-icon', 'fa-exclamation-triangle')
@section('error-code', '429')
@section('error-title', __('site.too_many_requests'))
@section('error-description', __('site.too_many_requests_message'))
