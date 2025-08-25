<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>{{ __('site.account_activation') }}</title>
</head>

<body
    style="margin:0; padding:0; background-color:#f5f6fa; font-family:Tahoma, Arial, sans-serif; direction:rtl; text-align:right;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f5f6fa">
        <tr>
            <td align="center">
                <table width="650" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08); margin:30px auto;">

                    <!-- Header -->
                    <tr>
                        <td align="center" bgcolor="#2c3e50" style="padding:30px;">
                            <img src="{{ asset('site_assets/images/logo.png') }}" alt="{{ config('app.name') }}"
                                width="160" style="margin-bottom:15px; display:block;">
                            <h1
                                style="color:#ffffff; font-size:26px; margin:0; font-weight:bold; text-shadow:0 1px 2px rgba(0,0,0,0.3);">
                                {{ __('site.welcome_to') }} {{ config('app.name') }}
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px;">
                            <h2
                                style="color:#2c3e50; font-size:20px; margin:0 0 20px 0; border-bottom:1px solid #eee; padding-bottom:10px;">
                                {{ __('site.hello') }} {{ $user->f_name }} {{ $user->l_name }}،
                            </h2>

                            <p style="font-size:16px; color:#444; line-height:1.7; margin-bottom:20px;">
                                {{ __('site.thank_you_for_registration') }}
                            </p>

                            <table cellpadding="0" cellspacing="0" border="0" align="center"
                                style="margin:30px auto;">
                                <tr>
                                    <td align="center" bgcolor="#27ae60" style="border-radius:50px;">
                                        <a href="{{ $activationUrl }}"
                                            style="display:inline-block; padding:14px 35px; color:#fff; text-decoration:none; font-size:18px; font-weight:bold; font-family:Arial, sans-serif; border-radius:50px;">
                                            {{ __('site.activate_account') }}
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:15px; margin-top:30px; margin-bottom:15px; font-weight:bold;">
                                {{ __('site.or_copy_link') }}:
                            </p>
                            <p
                                style="font-size:14px; color:#3498db; word-break:break-all; direction:ltr; text-align:left;">
                                <a href="{{ $activationUrl }}"
                                    style="color:#3498db; text-decoration:none;">{{ $activationUrl }}</a>
                            </p>

                            <div
                                style="margin-top:30px; padding:15px; background:#fef9e7; border-right:4px solid #f39c12; border-radius:8px; font-size:14px; color:#7f8c8d; line-height:1.6;">
                                <p>{{ __('site.activation_expire_message') }}</p>
                                <p>{{ __('site.if_not_requested') }}</p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td bgcolor="#2c3e50" align="center" style="padding:30px;">
                            <table cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td>
                                        <a href="https://www.facebook.com/tobecharismatic"><img
                                                src="https://cdn-icons-png.flaticon.com/128/733/733547.png"
                                                alt="Facebook" width="32" style="margin:0 8px;"></a>
                                        <a href="https://twitter.com/tobecharismatic"><img
                                                src="https://cdn-icons-png.flaticon.com/128/733/733579.png"
                                                alt="Twitter" width="32" style="margin:0 8px;"></a>
                                        <a href="https://www.instagram.com/tobecharismatic/"><img
                                                src="https://cdn-icons-png.flaticon.com/128/733/733558.png"
                                                alt="Instagram" width="32" style="margin:0 8px;"></a>
                                        <a href="https://www.linkedin.com/company/tobecharismatic/"><img
                                                src="https://cdn-icons-png.flaticon.com/128/733/733609.png"
                                                alt="LinkedIn" width="32" style="margin:0 8px;"></a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:rgba(255,255,255,0.7); font-size:13px; margin-top:20px;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}.
                                {{ __('site.all_rights_reserved') }}
                            </p>
                            <p style="color:rgba(255,255,255,0.6); font-size:12px; margin-top:10px;">
                                {{ config('app.name') }} - {{ __('site.address_line') }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
