@extends('site.layouts.app')

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.login') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('login') }}">{{ __('site.login') }}</a></li>
            </ul>
        </div>
    </section>

    <section class="login">
        <div class="container-fluid">
            <div class="login_content">
                <h3>{{ __('site.login') }}</h3>
                <h4>{{ __('site.welcome_please') }} <span>{{ __('site.login') }}</span></h4>
                <div class="alert alert-success">
                    تم ارسال بريد إلكتروني لديك للتحقق من ملكية البريد الإلكتروني فضلك قم بفتح البريد المرسل لك ومن ثم اضغط
                    علي زر التحقق لتفعيل الحساب
                </div>
                <div class="alert alert-warning">
                    اذا لم تجد الرسالة ربما تستغرق عملية الارسال 5 دقائق أو ابحث عنها بالرسائل الغير مرغوب فيها او قم بإرسال
                    طلب جديد من الأسفل
                </div>
                <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="d-inline btn btn-link p-0">
                        click here to request another
                    </button>.
                </form>
            </div>
        </div>
    </section>
@endsection
