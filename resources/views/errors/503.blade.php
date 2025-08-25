@extends('errors.layout')

@section('error-icon', 'fa-clock-o')
@section('error-code', '503')
@section('error-title', __('site.service_unavailable'))
@section('error-description', __('site.service_unavailable_message'))
