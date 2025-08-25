@extends('backend.layouts.app')

@section('style')
    <link href="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <style>
        .nav-pills,
        .nav-tabs {
            margin: 0;
        }

        ,
        .error-page-container {
            margin-top: 11%;
        }
    </style>
@endsection

@section('content')
    <div class="message"></div>

    @include('errors.messages')
    <div class="error-page-container" style="margin-top: 11%;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="error-content">
                        <div class="error-icon">
                            <i class="fa @yield('error-icon', 'fa-exclamation-circle')"></i>
                        </div>
                        <h1 class="error-code">@yield('error-code')</h1>
                        <h2 class="error-title">@yield('error-title')</h2>
                        <p class="error-description">@yield('error-description')</p>
                        <div class="error-actions">
                            <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                                <i class="fa fa-home"></i> {{ __('site.back_to_home') }}
                            </a>
                            <a href="{{ url('site/contact') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fa fa-envelope"></i> {{ __('site.contact_us') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .error-page-container {
            padding: 80px 0;
            background-color: #f8f9fa;
            min-height: 70vh;
            display: flex;
            align-items: center;
        }

        .error-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 50px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .error-icon {
            font-size: 60px;
            color: #FF7F00;
            margin-bottom: 20px;
        }

        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #FF7F00;
            margin: 0;
            line-height: 1;
        }

        .error-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .error-description {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        .error-actions {
            margin-top: 30px;
        }

        .error-actions .btn {
            margin: 0 10px;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .error-actions .btn-primary {
            background-color: #FF7F00;
            border-color: #FF7F00;
        }

        .error-actions .btn-primary:hover {
            background-color: #e67300;
            border-color: #e67300;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 127, 0, 0.3);
        }

        .error-actions .btn-outline-secondary {
            color: #555;
            border-color: #ccc;
        }

        .error-actions .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #333;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 767px) {
            .error-code {
                font-size: 80px;
            }

            .error-title {
                font-size: 22px;
            }

            .error-description {
                font-size: 16px;
            }

            .error-actions .btn {
                margin: 5px;
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
@endsection
