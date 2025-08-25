@extends('errors.layout')

@section('error-icon', 'fa-lock')
@section('error-code', '403')
@section('error-title', __('site.access_forbidden'))
@section('error-description', __('site.access_forbidden_message'))
