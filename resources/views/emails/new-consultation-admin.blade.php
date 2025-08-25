<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب استشارة جديد</title>
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
                                طلب استشارة جديد!</h1>
                        </td>
                    </tr>

                    <!-- محتوى الرسالة -->
                    <tr>
                        <td style="padding: 20px 40px;">
                            <p style="margin: 0 0 15px; font-size: 16px; line-height: 1.6;">مرحباً،</p>
                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">تم استلام طلب استشارة جديد
                                من {{ $consultation->user->f_name }} {{ $consultation->user->l_name }}. فيما يلي تفاصيل
                                الطلب:</p>

                            <!-- معلومات الاستشارة -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                style="background-color: #f9f9ff; border-radius: 8px; margin: 0 0 25px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">اسم المستخدم:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $consultation->user->f_name }}
                                                        {{ $consultation->user->l_name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">البريد
                                                        الإلكتروني:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $consultation->user->email }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">تاريخ
                                                        الاستشارة:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $consultation->date }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">الوقت:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $consultation->hours }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">نوع الجلسة:</strong>
                                                    <span style="font-size: 15px; color: #333; margin-right: 5px;">
                                                        @if ($consultation->session_type == 1)
                                                            مباشر
                                                        @else
                                                            عن بعد
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <strong style="font-size: 15px; color: #555;">موضوع
                                                        الاستشارة:</strong>
                                                    <div style="font-size: 15px; color: #333; margin-top: 5px;">
                                                        {{ $consultation->subject }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 25px; font-size: 16px; line-height: 1.6; text-align: center;">يمكنك
                                الاطلاع على تفاصيل الطلب من خلال لوحة التحكم:</p>

                            <!-- زر الإجراء -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                style="margin: 0 0 25px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('consultations') }}"
                                            style="display: inline-block; padding: 12px 30px; background-color: #D4AF37; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; transition: background-color 0.3s;">عرض
                                            الطلب</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 30px 0 0; font-size: 16px; line-height: 1.6;">شكراً لك،</p>
                            <p style="margin: 5px 0 0; font-size: 16px; line-height: 1.6; font-weight: bold;">فريق
                                {{ config('app.name') }}</p>
                        </td>
                    </tr>

                    <!-- تذييل الرسالة -->
                    <tr>
                        <td
                            style="padding: 20px 40px; background-color: #f9f9f9; border-top: 1px solid #eaeaea; text-align: center;">
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
