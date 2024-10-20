@extends('backend.layouts.subscripe-app')

@section('content')
    <section class="payment">
        <div class="container-fluid">
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
                        <form class="form_info" method="POST" action="{{ route('postaddstudentsubscription') }}">
                            <div class="form-group">
                                <div class="block" id="pay_online"
                                    onclick="document.getElementById('payment_method').value = '1';">
                                    <div><img src="{{ asset('site_assets') }}/images/payment_2.png" style="width: 64px;">
                                    </div>
                                    <h4>المحافظ الالكترونية</h4>
                                    <input type="radio" name="payment" class="pay_online_input" style="display: none;">
                                </div>
                            </div>

                            <div class="pay_online_info" style="display: none;">
                                <div>
                                    <h3>يرجي تأكيد التحويل من خلال ارسال بيانات التحويل من <a href="#pay_online_form"
                                            id="pay_online_btn">هنا</a></h3>
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
                                <form class="form_info" method="POST" action="{{ route('postaddstudentsubscription') }}">
                                    @csrf
                                    <input type="text" name="payment_method" value="1" hidden>
                                    <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                                    <input type="text" name="course_id" value="{{ $course->id }}" hidden>
                                    <div class="form-group">
                                        <label><span>*</span>اختر المحفظة الالكترونية</label>
                                        <select name="e_wallet_id" class="form-control" required>
                                            <option value="" selected> {{ __('pages.choose-e_wallet') }} </option>
                                            @foreach ($e_wallets as $e_wallet)
                                                <option value="{{ $e_wallet->id }}">{{ $e_wallet->company_name_en }}
                                                    {{ $e_wallet->number }}</option>
                                            @endforeach
                                        </select>
                                        <span class="fas fa-credit-card"></span>
                                    </div>

                                    <div class="form-group" style="width: 48%;float: right;">
                                        <label><span>*</span>رقم المحفظة</label>
                                        <input type="text" name="user_e_wallet_number" class="form-control"
                                            placeholder="رقم المحفظة" required>
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
                                        <input type="number" name="amount" class="form-control" placeholder="المبلغ"
                                            required>
                                        <span class="fas fa-money-bill-wave"></span>
                                    </div>

                                    <div class="form-group" style="width: 48%;float: left;">
                                        <label>العملة</label>
                                        <input type="text" name="currency" class="form-control" placeholder="العملة">
                                        <span class="fas fa-coins"></span>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="form-group">
                                        <input type="submit" class="btn black_hover btn-success" value="ارسال">
                                    </div>

                                </form>
                            </div>

                            <div class="form-group">
                                <div class="block" id="bank_accounts">
                                    <div><img src="{{ asset('site_assets') }}/images/payment_4.png" style="width: 64px;">
                                    </div>
                                    <h4>تحويل بنكي</h4>
                                    <input type="radio" name="payment" class="bank_accounts_input" style="display: none;">
                                </div>
                            </div>
                        </form>

                        <div class="bank_accounts_form" style="display: none;">
                            <form class="form_info" method="POST" action="{{ route('postaddstudentsubscription') }}">
                                @csrf
                                <div>
                                    <h3>يرجي تأكيد التحويل من خلال ارسال بيانات التحويل من <a href="#trans_send"
                                            id="trans_btn">هنا</a></h3>
                                </div>

                                <h3>الحسابات البنكيه</h3>
                                @foreach ($banks as $bank)
                                    <div class="alert alert-info">
                                        <div class="col-md-4">{{ $bank->bank_name_ar }} <br> {{ $bank->acc_name_ar }}
                                        </div>
                                        <div class="col-md-4"> رقم الحساب <br> {{ $bank->acc_num }} </div>
                                        <div class="col-md-4">الايبان <br> {{ $bank->iban }}</div>
                                    </div>
                                @endforeach
                                <hr>
                            </form>
                        </div>

                        <div id="trans_send" style="display: none;">
                            <form class="form_info" method="POST" action="{{ route('postaddstudentsubscription') }}">
                                @csrf
                                <input type="text" name="payment_method" id="payment_method" value="0" hidden>
                                <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                                <input type="text" name="course_id" value="{{ $course->id }}" hidden>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="float: right;width: 48%;">
                                        <label><span>*</span>البنك </label>
                                        <select class="form-control" name="bank_id" required="">
                                            <option disabled="" selected="" value="">قم باختيار البنك
                                            </option>
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->acc_name_ar }}</option>
                                            @endforeach
                                        </select>
                                        <span class="fas fa-credit-card"></span>
                                    </div>
                                    <div class="form-group" style="float: left;width: 48%;">
                                        <label><span>*</span>الاسم المحول منه </label>
                                        <input type="text" class="form-control" name="user_bank_acc_name"
                                            required="" value="" placeholder="اكتب اسم المحول منه">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="form-group" style="float: left;width: 48%;">
                                        <label><span>*</span>تاريخ التحويل </label>
                                        <input type="date" class="form-control" name="transfer_date" required=""
                                            value="" placeholder="هنا يتكم كتباه تاريخ التحويل">
                                        <span class="fas fa-calendar-alt"></span>
                                    </div>
                                </div>

                                <div class="form-group" style="width: 48%;float: right;">
                                    <label><span>*</span>المبلغ</label>
                                    <input type="number" name="amount" class="form-control" placeholder="المبلغ"
                                        required>
                                    <span class="fas fa-money-bill-wave"></span>
                                </div>

                                <div class="clearfix"></div>

                                <div class="form-group">
                                    <label>العملة</label>
                                    <input type="text" name="currency" class="form-control" placeholder="العملة">
                                    <span class="fas fa-coins"></span>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn  btn-success" value="ارسال">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--
                                                                                                                         sub_payment
                                                                                                                            -->
@endsection


@section('script')
    <script>
        $('#pay_online').click(function(event) {
            event.preventDefault();
            $('.bank_accounts_input').attr('checked', false);
            $('.pay_online_input').attr('checked', true);
        });
        $('#bank_accounts').click(function(event) {
            event.preventDefault();
            $('.pay_online_input').attr('checked', false);
            $('.bank_accounts_input').attr('checked', true);
        });

        $('#pay_online').click(function(event) {
            event.preventDefault();
            $('.bank_accounts_form, #trans_send').css("display", "none");
            $('.pay_online_info').css("display", "block");
        });

        $('#pay_online_btn').click(function(event) {
            event.preventDefault();
            $('.pay_online_form').css("display", "block");
        });

        $('#bank_accounts').click(function(event) {
            event.preventDefault();
            $('.pay_online_form,.pay_online_info').css("display", "none");
            $('.bank_accounts_form').css("display", "block");
        });

        $('#trans_btn').click(function(event) {
            event.preventDefault();
            $('#trans_send').css("display", "block");
        });
    </script>
@endsection
