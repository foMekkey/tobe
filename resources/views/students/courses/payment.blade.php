@extends('backend.layouts.subscripe-app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style type="text/css">
        .alert-heading {
            margin-bottom: 5% !important;
            margin-top: 5% !important;
        }

        .alert p {
            margin-bottom: 5% !important;
            margin-top: 5% !important;
            margin-right: 5%;
        }

        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap');

        /* ===== متغيرات الألوان ===== */
        :root {
            --primary-color: #8A6D3B;
            --secondary-color: #1F1A16;
            --accent-color: #D4AF37;
            --text-color: #333;
            --light-color: #F9F5EB;
            --dark-color: #2C2C2C;
            --border-color: rgba(212, 175, 55, 0.3);
        }

        /* ===== الحاوية الرئيسية ===== */
        .luxury-program-container {
            font-family: "Cairo-Regular";
            background: linear-gradient(to bottom, var(--light-color), #fff);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin: 30px 0;
            overflow: hidden;
            position: relative;
            direction: rtl;
        }

        .luxury-program-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, var(--accent-color), var(--primary-color));
        }

        /* ===== الترويسة ===== */
        .luxury-program-header {
            padding: 30px 40px;
            background-color: var(--secondary-color);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .luxury-program-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, var(--accent-color) 0%, transparent 70%);
            opacity: 0.2;
            border-radius: 50%;
        }

        .luxury-program-title h2 {
            font-size: 32px;
            font-weight: 800;
            margin: 0;
            color: var(--accent-color);
            position: relative;
            display: inline-block;
        }

        .luxury-program-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            right: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
        }

        .luxury-program-subtitle {
            font-size: 18px;
            margin-top: 15px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 300;
        }

        /* ===== المحتوى ===== */
        .luxury-program-content {
            padding: 40px;
        }

        .luxury-program-description {
            font-size: 16px;
            line-height: 1.8;
            color: var(--text-color);
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
        }

        /* ===== الميزات ===== */
        .luxury-program-features {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 40px;
        }

        .luxury-feature {
            flex: 1;
            min-width: 250px;
            display: flex;
            gap: 15px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .luxury-feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .luxury-feature-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 20px;
        }

        .luxury-feature-content h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 10px;
            color: var(--primary-color);
        }

        .luxury-feature-content p {
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            color: var(--text-color);
        }

        /* ===== الجدول الزمني ===== */
        .luxury-program-schedule {
            background-color: rgba(212, 175, 55, 0.05);
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .luxury-program-schedule h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0 0 15px;
        }

        .luxury-program-schedule p {
            margin: 0 0 15px;
        }

        .luxury-program-schedule ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .luxury-program-schedule li {
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .luxury-program-schedule li i {
            color: var(--accent-color);
        }

        /* ===== دعوة للعمل ===== */
        .luxury-program-cta {
            text-align: center;
            padding: 20px;
            background: linear-gradient(to right, rgba(138, 109, 59, 0.05), rgba(212, 175, 55, 0.05));
            border-radius: 8px;
        }

        .luxury-program-cta p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .luxury-program-slogan {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            margin-top: 10px;
            position: relative;
            display: inline-block;
            padding: 0 20px;
        }

        .luxury-program-slogan::before,
        .luxury-program-slogan::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30px;
            height: 1px;
            background-color: var(--accent-color);
        }

        .luxury-program-slogan::before {
            right: -20px;
        }

        .luxury-program-slogan::after {
            left: -20px;
        }

        /* ===== تحسينات للجوال ===== */
        @media (max-width: 768px) {
            .luxury-program-header {
                padding: 25px;
            }

            .luxury-program-title h2 {
                font-size: 26px;
            }

            .luxury-program-subtitle {
                font-size: 16px;
            }

            .luxury-program-content {
                padding: 25px;
            }

            .luxury-program-features {
                flex-direction: column;
            }

            .luxury-feature {
                min-width: auto;
            }
        }
    </style>
    <section class="payment">
        <div class="container-fluid">

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($existingRegistration)
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                حالة طلب التسجيل في دورة: {{ $course->name }}
                            </h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        @if ($existingRegistration->status == 'pending')
                            <div class="alert alert-warning">
                                <h4 class="alert-heading">طلبك قيد المراجعة</h4>
                                <p>لقد قمت بالفعل بتقديم طلب تسجيل في هذه الدورة بتاريخ
                                    {{ $existingRegistration->created_at->format('Y-m-d') }}. الطلب حالياً قيد المراجعة من
                                    قبل الإدارة.</p>
                            </div>
                        @elseif($existingRegistration->status == 'rejected')
                            <div class="alert alert-danger">
                                <h4 class="alert-heading">تم رفض طلبك</h4>
                                <p>نأسف لإبلاغك أنه تم رفض طلب التسجيل الخاص بك في هذه الدورة.</p>
                                <p>يمكنك التواصل مع الإدارة للاستفسار عن سبب الرفض أو تقديم طلب جديد.</p>
                                <a href="{{ route('StudentCatalog') }}" class="btn btn-secondary">العودة إلى قائمة
                                    الدورات</a>
                            </div>
                        @elseif($existingRegistration->status == 'approved')
                            <div class="alert alert-success">
                                <h4 class="alert-heading">تمت الموافقة على طلبك!</h4>
                                <p>تهانينا! تمت الموافقة على طلب التسجيل الخاص بك في دورة {{ $course->name }}.</p>
                                <p>يرجى إكمال عملية الدفع أدناه للتأكيد النهائي على تسجيلك.</p>
                            </div>

                            <!-- هنا يظهر جزء الدفع كاملاً -->
                            <div style="flex-direction: row-reverse;">
                                <div class="main_title">
                                    <h3>معلومات الدفع</h3>
                                    <h1>قم باختيار ما يناسبك</h1>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 pull-left">
                                    <div class="offer">
                                        <h3> {{ $course->name }}</h3>
                                        <div class="list">
                                            <p>
                                                {{ $course->desc }}
                                            </p>
                                            <h1>${{ $course->price }}<span></span></h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 pull-right">
                                    <div class="payment_method">
                                        <form class="form_info" method="POST"
                                            action="{{ route('postaddstudentsubscription') }}">
                                            <div class="form-group">
                                                <div class="block" id="pay_online"
                                                    onclick="document.getElementById('payment_method').value = '1';">
                                                    <div><img src="{{ asset('site_assets') }}/images/payment_2.png"
                                                            style="width: 64px;">
                                                    </div>
                                                    <h4>المحافظ الالكترونية</h4>
                                                    <input type="radio" name="payment" class="pay_online_input"
                                                        style="display: none;">
                                                </div>
                                            </div>

                                            <div class="pay_online_info" style="display: none;">
                                                <div>
                                                    <h3>يرجي تأكيد التحويل من خلال ارسال بيانات التحويل من <a
                                                            href="#pay_online_form" id="pay_online_btn">هنا</a></h3>
                                                </div>
                                                <h3>المحافظ الالكترونية</h3>
                                                @foreach ($e_wallets as $e_wallet)
                                                    <div class="alert alert-info">
                                                        <div class="col-md-6">{{ $e_wallet->company_name_en }}</div>
                                                        <div class="col-md-6">{{ $e_wallet->number }}</div>
                                                    </div>
                                                @endforeach
                                                <hr>
                                            </div>

                                            <div class="pay_online_form" id="pay_online_form" style="display: none;">
                                                <form class="form_info" method="POST"
                                                    action="{{ route('postaddstudentsubscription') }}">
                                                    @csrf
                                                    <input type="text" name="payment_method" value="1" hidden>
                                                    <input type="text" name="user_id" value="{{ auth()->user()->id }}"
                                                        hidden>
                                                    <input type="text" name="course_id" value="{{ $course->id }}"
                                                        hidden>
                                                    <input type="text" name="registration_id"
                                                        value="{{ $existingRegistration->id }}" hidden>
                                                    <div class="form-group">
                                                        <label><span>*</span>اختر المحفظة الالكترونية</label>
                                                        <select name="e_wallet_id" class="form-control" required>
                                                            <option value="" selected>
                                                                {{ __('pages.choose-e_wallet') }} </option>
                                                            @foreach ($e_wallets as $e_wallet)
                                                                <option value="{{ $e_wallet->id }}">
                                                                    {{ $e_wallet->company_name_en }}
                                                                    {{ $e_wallet->number }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="fas fa-credit-card"></span>
                                                    </div>

                                                    <div class="form-group" style="width: 48%;float: right;">
                                                        <label><span>*</span>رقم المحفظة</label>
                                                        <input type="text" name="user_e_wallet_number"
                                                            class="form-control" placeholder="رقم المحفظة" required>
                                                        <span class="far fa-credit-card"></span>
                                                    </div>

                                                    <div class="form-group" style="width: 48%;float: left;">
                                                        <label><span>*</span>تاريخ التحويل</label>
                                                        <input type="date" name="transfer_date" class="form-control"
                                                            placeholder="تاريخ التحويل" required>
                                                        <span class="fas fa-calendar-alt"></span>
                                                    </div>

                                                    <div class="form-group" style="width: 48%;float: right;">
                                                        <label><span>*</span>المبلغ</label>
                                                        <input type="number" name="amount" class="form-control"
                                                            placeholder="المبلغ" required>
                                                        <span class="fas fa-money-bill-wave"></span>
                                                    </div>

                                                    <div class="form-group" style="width: 48%;float: left;">
                                                        <label>العملة</label>
                                                        <input type="text" name="currency" class="form-control"
                                                            placeholder="العملة">
                                                        <span class="fas fa-coins"></span>
                                                    </div>

                                                    <div class="clearfix"></div>

                                                    <div class="form-group">
                                                        <input type="submit" class="btn black_hover btn-success"
                                                            value="ارسال">
                                                    </div>

                                                </form>
                                            </div>

                                            <div class="form-group">
                                                <div class="block" id="bank_accounts">
                                                    <div><img src="{{ asset('site_assets') }}/images/payment_4.png"
                                                            style="width: 64px;">
                                                    </div>
                                                    <h4>تحويل بنكي</h4>
                                                    <input type="radio" name="payment" class="bank_accounts_input"
                                                        style="display: none;">
                                                </div>
                                            </div>
                                        </form>

                                        <div class="bank_accounts_form" style="display: none;">
                                            <form class="form_info" method="POST"
                                                action="{{ route('postaddstudentsubscription') }}">
                                                @csrf
                                                <div>
                                                    <h3>يرجي تأكيد التحويل من خلال ارسال بيانات التحويل من <a
                                                            href="#trans_send" id="trans_btn">هنا</a></h3>
                                                </div>

                                                <h3>الحسابات البنكيه</h3>
                                                @foreach ($banks as $bank)
                                                    <div class="alert alert-info">
                                                        <div class="col-md-4">{{ $bank->bank_name_ar }} <br>
                                                            {{ $bank->acc_name_ar }}
                                                        </div>
                                                        <div class="col-md-4"> رقم الحساب <br> {{ $bank->acc_num }}
                                                        </div>
                                                        <div class="col-md-4">الايبان <br> {{ $bank->iban }}</div>
                                                    </div>
                                                @endforeach
                                                <hr>
                                            </form>
                                        </div>

                                        <div id="trans_send" style="display: none;">
                                            <form class="form_info" method="POST"
                                                action="{{ route('postaddstudentsubscription') }}">
                                                @csrf
                                                <input type="text" name="payment_method" id="payment_method"
                                                    value="0" hidden>
                                                <input type="text" name="user_id" value="{{ auth()->user()->id }}"
                                                    hidden>
                                                <input type="text" name="course_id" value="{{ $course->id }}"
                                                    hidden>
                                                <input type="text" name="registration_id"
                                                    value="{{ $existingRegistration->id }}" hidden>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group" style="float: right;width: 48%;">
                                                        <label><span>*</span>البنك </label>
                                                        <select class="form-control" name="bank_id" required="">
                                                            <option disabled="" selected="" value="">قم
                                                                باختيار البنك
                                                            </option>
                                                            @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}">
                                                                    {{ $bank->acc_name_ar }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="fas fa-credit-card"></span>
                                                    </div>
                                                    <div class="form-group" style="float: left;width: 48%;">
                                                        <label><span>*</span>الاسم المحول منه </label>
                                                        <input type="text" class="form-control"
                                                            name="user_bank_acc_name" required="" value=""
                                                            placeholder="اكتب اسم المحول منه">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                    <div class="form-group" style="float: left;width: 48%;">
                                                        <label><span>*</span>تاريخ التحويل </label>
                                                        <input type="date" class="form-control" name="transfer_date"
                                                            required="" value=""
                                                            placeholder="هنا يتكم كتباه تاريخ التحويل">
                                                        <span class="fas fa-calendar-alt"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="width: 48%;float: right;">
                                                    <label><span>*</span>المبلغ</label>
                                                    <input type="number" name="amount" class="form-control"
                                                        placeholder="المبلغ" required>
                                                    <span class="fas fa-money-bill-wave"></span>
                                                </div>

                                                <div class="clearfix"></div>

                                                <div class="form-group">
                                                    <input type="submit" class="btn black_hover btn-success"
                                                        value="ارسال">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="luxury-program-container">
                    <div class="luxury-program-header">
                        <div class="luxury-program-title">
                            <h2>الشخصية القضائية</h2>
                            <div class="luxury-program-subtitle">مشروع متكامل لتطوير مهارات الاتصال لقضاة المجلس الأعلى
                                للقضاء</div>
                        </div>
                    </div>

                    <div class="luxury-program-content">
                        <div class="luxury-program-description">
                            <p>مشروع متكامل لتطوير مهارات الاتصال لقضاة المجلس الأعلى للقضاء في قطر، يعتمد على بناء
                                كاريزما اتصالية خاصة لكل قاضي من خلال منهجية تعتمد على التدريب الجماعي والتوجيه الشخصي
                                الذي يحافظ على خصوصية وسرية ووقت كل قاضي مع تطبيقات عملية في قوالب متعددة لتمكين المهارة
                                المكتسبة من سلوك القاضي.</p>
                        </div>

                        <div class="luxury-program-features">
                            <div class="luxury-feature">
                                <div class="luxury-feature-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="luxury-feature-content">
                                    <h3>تجربة متكاملة</h3>
                                    <p>يعيش كل قاضي تجربة متكاملة لمدة 3 شهور يحضر فيها تدريباً جماعياً ليوم واحد كل
                                        أسبوع.</p>
                                </div>
                            </div>

                            <div class="luxury-feature">
                                <div class="luxury-feature-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="luxury-feature-content">
                                    <h3>توجيه شخصي</h3>
                                    <p>ساعات توجيه شخصي في جلسات فردية خاصة على مدار الوقت مع مستشار شخصي.</p>
                                </div>
                            </div>

                            <div class="luxury-feature">
                                <div class="luxury-feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="luxury-feature-content">
                                    <h3>تطبيق عملي</h3>
                                    <p>يمارس القاضي تطبيقاً عملياً كل أسبوع في محاكاة لتجربة التواصل مع الجماهير.</p>
                                </div>
                            </div>
                        </div>

                        <div class="luxury-program-schedule">
                            <h3>الجدول الزمني المرن</h3>
                            <p>يضمن البرنامج حفاظاً على وقت القاضي الذي لن يكون مشغولاً إلا:</p>
                            <ul>
                                <li><i class="fas fa-check-circle"></i> يوماً واحداً في الأسبوع للتدريب الجماعي</li>
                                <li><i class="fas fa-check-circle"></i> أمسية تطبيقية مرنة</li>
                                <li><i class="fas fa-check-circle"></i> ساعة واحدة من وقته أسبوعياً لجلسة التوجيه
                                    والاستشارة</li>
                            </ul>
                        </div>

                        <div class="luxury-program-cta">
                            <p>يمكنك اختيار التوقيت المناسب للاستمتاع بتجربتنا الفريدة من بين 6 فترات زمنية موضحة
                                أدناه...</p>
                            <div class="luxury-program-slogan">فأهلاً بكم معنا في رحلة بناء كاريزمتك الخاصة...</div>
                        </div>
                    </div>
                </div>
                <!-- إذا لم يكن هناك طلب تسجيل سابق، يظهر نموذج التسجيل -->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                استمارة التسجيل في دورة: {{ $course->name }}
                            </h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="registration-intro mb-4">
                            <h4>معلومات هامة قبل التسجيل:</h4>
                            <p>يرجى تعبئة جميع البيانات المطلوبة بدقة لضمان معالجة طلبك بشكل صحيح. البيانات المشار إليها
                                بعلامة (*) إلزامية.</p>
                            <p>بعد تقديم الطلب، ستتم مراجعته من قبل الإدارة وسيتم إعلامك بالنتيجة.</p>
                        </div>

                        <form class="kt-form" method="POST" action="{{ route('StudentSubscription', $course->id) }}">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">

                            <h5 class="mb-4">اختيار الفوج</h5>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">الفوج <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="cohort_id" class="form-control @error('cohort_id') is-invalid @enderror"
                                        required>
                                        <option value="">-- اختر الفوج --</option>
                                        @foreach ($availableCohorts as $cohort)
                                            <option value="{{ $cohort->id }}"
                                                {{ old('cohort_id') == $cohort->id ? 'selected' : '' }}>
                                                {{ $cohort->name }} ({{ $cohort->start_date->format('Y-m-d') }} إلى
                                                {{ $cohort->end_date->format('Y-m-d') }})
                                                - المقاعد المتبقية: {{ $cohort->remainingSlots() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cohort_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

                            <h5 class="mb-4">البيانات الشخصية</h5>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">الاسم الكامل <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="full_name"
                                        class="form-control @error('full_name') is-invalid @enderror"
                                        value="{{ old('full_name', auth()->user()->name) }}" required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">تاريخ الميلاد <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="date" name="birth_date"
                                        class="form-control @error('birth_date') is-invalid @enderror"
                                        value="{{ old('birth_date') }}" required>
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">المؤهل العلمي <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="education"
                                        class="form-control @error('education') is-invalid @enderror"
                                        value="{{ old('education') }}" required>
                                    @error('education')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">الدورات السابقة التي حضرتها:</label>
                                <div class="col-lg-9">
                                    <textarea name="previous_courses" class="form-control @error('previous_courses') is-invalid @enderror"
                                        rows="3">{{ old('previous_courses') }}</textarea>
                                    @error('previous_courses')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

                            <h5 class="mb-4">معلومات العمل</h5>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">الوظيفة الحالية <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="current_job"
                                        class="form-control @error('current_job') is-invalid @enderror"
                                        value="{{ old('current_job') }}" required>
                                    @error('current_job')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">مهام إضافية تقوم بها:</label>
                                <div class="col-lg-9">
                                    <textarea name="additional_tasks" class="form-control @error('additional_tasks') is-invalid @enderror"
                                        rows="3">{{ old('additional_tasks') }}</textarea>
                                    @error('additional_tasks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">تاريخ الالتحاق بالمجلس: <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="date" name="join_date"
                                        class="form-control @error('join_date') is-invalid @enderror"
                                        value="{{ old('join_date') }}" required>
                                    @error('join_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">مواهب أو مهارات وقدرات خاصة خارج نطاق الوظيفة تحب
                                    ممارستها:</label>
                                <div class="col-lg-9">
                                    <textarea name="special_skills" class="form-control @error('special_skills') is-invalid @enderror" rows="3">{{ old('special_skills') }}</textarea>
                                    @error('special_skills')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">مشكلات شخصية في التواصل:</label>
                                <div class="col-lg-9">
                                    <textarea name="communication_problems" class="form-control @error('communication_problems') is-invalid @enderror"
                                        rows="3">{{ old('communication_problems') }}</textarea>
                                    @error('communication_problems')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">مشكلات خاصة (نفسية – سلوكية – اجتماعية) تحتاج
                                    المساعدة فيها:</label>
                                <div class="col-lg-9">
                                    <textarea name="personal_problems" class="form-control @error('personal_problems') is-invalid @enderror"
                                        rows="3">{{ old('personal_problems') }}</textarea>
                                    <small class="form-text text-muted">هذه المعلومات سرية ولا يطلع عليها غير المستشار
                                        رمضان الموصل.</small>
                                    @error('personal_problems')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">مهارات تحتاج تطويرها:</label>
                                <div class="col-lg-9">
                                    <textarea name="skills_to_develop" class="form-control @error('skills_to_develop') is-invalid @enderror"
                                        rows="3">{{ old('skills_to_develop') }}</textarea>
                                    @error('skills_to_develop')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">رسالة خاصة لمستشارك الشخصي:</label>
                                <div class="col-lg-9">
                                    <textarea name="message_to_consultant" class="form-control @error('message_to_consultant') is-invalid @enderror"
                                        rows="3">{{ old('message_to_consultant') }}</textarea>
                                    @error('message_to_consultant')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

                            <h5 class="mb-4">بيانات التواصل</h5>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">رقم الجوال: <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="mobile_number"
                                        class="form-control @error('mobile_number') is-invalid @enderror"
                                        value="{{ old('mobile_number') }}" required>
                                    @error('mobile_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">رقم الواتس آب (إن كان مختلفاً):</label>
                                <div class="col-lg-9">
                                    <input type="text" name="whatsapp_number"
                                        class="form-control @error('whatsapp_number') is-invalid @enderror"
                                        value="{{ old('whatsapp_number') }}">
                                    @error('whatsapp_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">البريد الإلكتروني: <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-9">
                                            <button type="submit" class="btn btn-brand">تسجيل الطلب</button>
                                            <a href="{{ route('StudentCatalog') }}" class="btn btn-secondary">إلغاء</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // تفعيل الدفع عبر المحافظ الإلكترونية
            $("#pay_online").click(function() {
                $(".pay_online_input").prop("checked", true);
                $(".pay_online_info").slideDown();
                $(".bank_accounts_form").slideUp();
                $("#trans_send").slideUp();
                document.getElementById('payment_method').value = '1';
            });

            // تفعيل الدفع عبر التحويل البنكي
            $("#bank_accounts").click(function() {
                $(".bank_accounts_input").prop("checked", true);
                $(".bank_accounts_form").slideDown();
                $(".pay_online_info").slideUp();
                $(".pay_online_form").slideUp();
                document.getElementById('payment_method').value = '2';
            });

            // عرض نموذج المحافظ الإلكترونية
            $("#pay_online_btn").click(function(e) {
                e.preventDefault();
                $(".pay_online_form").slideDown();
            });

            // عرض نموذج التحويل البنكي
            $("#trans_btn").click(function(e) {
                e.preventDefault();
                $("#trans_send").slideDown();
            });
        });
    </script>
@endsection
