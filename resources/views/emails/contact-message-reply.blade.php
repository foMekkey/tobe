<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرد على رسالتك</title>
</head>

<body
    style="margin: 0; padding: 0; direction: rtl; text-align: right; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f7f7f7; color: #333;">
    <!-- الحاوية الرئيسية -->
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f7f7f7; padding: 20px;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="600"
                    style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); overflow: hidden; margin: 0 auto;">
                    <!-- رأس الرسالة -->
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td
                                        style="padding: 30px 0; text-align: center; background: linear-gradient(135deg, #2b5876 0%, #4e4376 100%);">
                                        <img src="{{ asset('admin/assets/media/logos/logo-4.png') }}"
                                            alt="{{ config('app.name') }}" style="max-width: 180px; height: auto;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- عنوان الرسالة -->
                    <tr>
                        <td style="padding: 30px 40px 0;">
                            <h1 style="margin: 0; font-size: 24px; color: #333; font-weight: 600; text-align: center;">
                                الرد على رسالتك
                            </h1>
                        </td>
                    </tr>

                    <!-- محتوى الرسالة -->
                    <tr>
                        <td style="padding: 20px 40px;">
                            <p style="margin: 0 0 15px; font-size: 16px; line-height: 1.6;">مرحباً {{ $name }}،
                            </p>
                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">شكراً على تواصلك معنا. فيما
                                يلي الرد على رسالتك:</p>

                            <!-- الرد -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                style="background-color: #f9f9ff; border-radius: 8px; margin: 0 0 25px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <div style="font-size: 15px; color: #333; line-height: 1.6;">
                                            {!! nl2br(e($reply)) !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 15px; font-size: 16px; line-height: 1.6;">للتذكير، هذا هو نص رسالتك
                                الأصلية:</p>

                            <!-- الرسالة الأصلية -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                style="background-color: #f0f0f0; border-radius: 8px; margin: 0 0 25px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <div
                                            style="font-size: 14px; color: #555; line-height: 1.6; font-style: italic;">
                                            {!! nl2br(e($originalMessage)) !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 25px; font-size: 16px; line-height: 1.6;">إذا كان لديك أي استفسارات
                                أخرى، يرجى عدم التردد في التواصل معنا مرة أخرى.</p>

                            <p style="margin: 30px 0 0; font-size: 16px; line-height: 1.6;">مع خالص التحية،</p>
                            <p style="margin: 5px 0 0; font-size: 16px; line-height: 1.6; font-weight: bold;">فريق
                                {{ config('app.name') }}</p>
                        </td>
                    </tr>

                    <!-- تذييل الرسالة -->
                    <tr>
                        <td
                            style="padding: 20px 40px; background-color: #f9f9f9; border-top: 1px solid #eaeaea; text-align: center;">
                            <p style="margin: 0 0 10px; font-size: 13px; color: #777;">إذا كنت بحاجة إلى أي مساعدة، يرجى
                                التواصل معنا.</p>
                            <p style="margin: 0; font-size: 13px; color: #777;">&copy; {{ date('Y') }}
                                {{ config('app.name') }}. جميع الحقوق محفوظة.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
