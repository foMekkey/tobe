@extends('errors.layout')

@section('error-icon', 'fa-wrench')
@section('error-code', '')
@section('error-title', __('site.maintenance_mode'))
@section('error-description')
    <div class="maintenance-message">
        <p>{{ __('site.maintenance_message') }}</p>
        <div class="countdown">
            <div class="countdown-item">
                <span id="hours">00</span>
                <span class="countdown-label">{{ __('site.hours') }}</span>
            </div>
            <div class="countdown-item">
                <span id="minutes">00</span>
                <span class="countdown-label">{{ __('site.minutes') }}</span>
            </div>
            <div class="countdown-item">
                <span id="seconds">00</span>
                <span class="countdown-label">{{ __('site.seconds') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // تعيين وقت انتهاء الصيانة (مثال: بعد ساعتين)
        var maintenanceEndTime = new Date();
        maintenanceEndTime.setHours(maintenanceEndTime.getHours() + 2);

        // تحديث العد التنازلي كل ثانية
        var countdownTimer = setInterval(function() {
            var now = new Date().getTime();
            var distance = maintenanceEndTime - now;

            // حساب الساعات والدقائق والثواني
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // عرض النتيجة
            document.getElementById("hours").innerHTML = (hours < 10 ? "0" : "") + hours;
            document.getElementById("minutes").innerHTML = (minutes < 10 ? "0" : "") + minutes;
            document.getElementById("seconds").innerHTML = (seconds < 10 ? "0" : "") + seconds;

            // إذا انتهى العد التنازلي
            if (distance < 0) {
                clearInterval(countdownTimer);
                document.getElementById("hours").innerHTML = "00";
                document.getElementById("minutes").innerHTML = "00";
                document.getElementById("seconds").innerHTML = "00";

                // إعادة تحميل الصفحة
                setTimeout(function() {
                    window.location.reload();
                }, 3000);
            }
        }, 1000);
    </script>
@endsection

@section('styles')
    @parent
    <style>
        .maintenance-message {
            margin-bottom: 30px;
        }

        .countdown {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 15px;
        }

        .countdown-item span:first-child {
            font-size: 36px;
            font-weight: 700;
            color: #FF7F00;
            background-color: rgba(255, 127, 0, 0.1);
            border-radius: 8px;
            padding: 10px 15px;
            min-width: 80px;
            text-align: center;
        }

        .countdown-label {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
    </style>
@endsection
