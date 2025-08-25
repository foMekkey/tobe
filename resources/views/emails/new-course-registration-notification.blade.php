<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب انضمام جديد للدورة</title>
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
                                طلب انضمام جديد للدورة</h1>
                        </td>
                    </tr>

                    <!-- محتوى الرسالة -->
                    <tr>
                        <td style="padding: 20px 40px;">
                            <p style="margin: 0 0 15px; font-size: 16px; line-height: 1.6;">مرحباً،</p>
                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">تم استلام طلب انضمام جديد
                                للدورة. فيما يلي تفاصيل الطلب:</p>

                            <!-- معلومات الطلب -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                style="background-color: #f9f9ff; border-radius: 8px; margin: 0 0 25px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">الاسم الكامل:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $registration->full_name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">البريد
                                                        الإلكتروني:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $registration->email }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">رقم الجوال:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $registration->mobile_number }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">الدورة:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $registration->course->name ?? 'غير محدد' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #eaeaea;">
                                                    <strong style="font-size: 15px; color: #555;">الفوج:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $registration->cohort->name ?? 'غير محدد' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <strong style="font-size: 15px; color: #555;">تاريخ
                                                        التقديم:</strong>
                                                    <span
                                                        style="font-size: 15px; color: #333; margin-right: 5px;">{{ $registration->created_at->format('Y-m-d H:i') }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 25px; font-size: 16px; line-height: 1.6; text-align: center;">يمكنك
                                عرض تفاصيل الطلب كاملة والرد عليه من خلال الرابط أدناه:</p>

                            <!-- زر الإجراء -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                style="margin: 0 0 25px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $viewUrl }}"
                                            style="display: inline-block; padding: 12px 30px; background-color: #D4AF37; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; transition: background-color 0.3s;">عرض
                                            تفاصيل الطلب</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 30px 0 0; font-size: 16px; line-height: 1.6;">يرجى مراجعة الطلب في أقرب
                                وقت ممكن.</p>
                            <p style="margin: 5px 0 0; font-size: 16px; line-height: 1.6;">مع خالص التحية،</p>
                            <p style="margin: 5px 0 0; font-size: 16px; line-height: 1.6; font-weight: bold;">فريق
                                {{ config('app.name') }}</p>
                        </td>
                    </tr>

                    <!-- تذييل الرسالة -->
                    <tr>
                        <td
                            style="padding: 20px 40px; background-color: #f9f9f9; border-top: 1px solid #eaeaea; text-align: center;">
                            <p style="margin: 0 0 10px; font-size: 13px; color: #777;">هذا البريد الإلكتروني تم إرساله
                                تلقائياً، يرجى عدم الرد عليه.</p>
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
