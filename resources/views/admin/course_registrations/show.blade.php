@extends('backend.layouts.app')

@section('page-main-title', 'تفاصيل طلب التسجيل')

@section('style')
    <style>
        .registration-details .form-group {
            margin-bottom: 1.5rem;
        }

        .registration-details .form-control-static {
            padding-top: 0.65rem;
            padding-bottom: 0.65rem;
        }

        .registration-status {
            padding: 1.5rem;
            border-radius: 4px;
            margin-bottom: 2rem;
        }

        .registration-status.pending {
            background-color: rgba(255, 184, 34, 0.1);
            border-left: 4px solid #ffb822;
        }

        .registration-status.approved {
            background-color: rgba(29, 201, 183, 0.1);
            border-left: 4px solid #1dc9b7;
        }

        .registration-status.rejected {
            background-color: rgba(253, 57, 122, 0.1);
            border-left: 4px solid #fd397a;
        }

        .registration-status h4 {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .registration-status p {
            margin-bottom: 0;
        }

        .section-title {
            border-bottom: 1px solid #ebedf2;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            معلومات طلب التسجيل
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <!-- حالة الطلب -->
                    <div class="registration-status {{ $registration->status }}">
                        @if ($registration->status == 'pending')
                            <h4>الطلب قيد المراجعة</h4>
                            <p>لم يتم اتخاذ قرار بشأن هذا الطلب بعد.</p>
                        @elseif($registration->status == 'approved')
                            <h4>تم قبول الطلب</h4>
                            <p>تم قبول الطلب بتاريخ: {{ $registration->updated_at->format('Y-m-d H:i') }}</p>
                        @elseif($registration->status == 'rejected')
                            <h4>تم رفض الطلب</h4>
                            <p>تم رفض الطلب بتاريخ: {{ $registration->updated_at->format('Y-m-d H:i') }}</p>
                            @if ($registration->rejection_reason)
                                <p><strong>سبب الرفض:</strong> {{ $registration->rejection_reason }}</p>
                            @endif
                        @endif
                    </div>

                    <div class="registration-details">
                        <!-- معلومات الدورة والفوج -->
                        <h5 class="section-title">معلومات الدورة والفوج</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الدورة:</label>
                                    <p class="form-control-static">{{ $registration->course->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الفوج:</label>
                                    <p class="form-control-static">{{ $registration->cohort->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاريخ بداية الفوج:</label>
                                    <p class="form-control-static">{{ $registration->cohort->start_date->format('Y-m-d') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاريخ نهاية الفوج:</label>
                                    <p class="form-control-static">{{ $registration->cohort->end_date->format('Y-m-d') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- البيانات الشخصية -->
                        <h5 class="section-title">البيانات الشخصية</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الاسم الكامل:</label>
                                    <p class="form-control-static">{{ $registration->full_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاريخ الميلاد:</label>
                                    <p class="form-control-static">{{ $registration->birth_date }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>المؤهل العلمي:</label>
                                    <p class="form-control-static">{{ $registration->education }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>الدورات السابقة:</label>
                                    <p class="form-control-static">{{ $registration->previous_courses ?: 'لا يوجد' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- معلومات العمل -->
                        <h5 class="section-title">معلومات العمل</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الوظيفة الحالية:</label>
                                    <p class="form-control-static">{{ $registration->current_job }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاريخ الالتحاق بالمجلس:</label>
                                    <p class="form-control-static">{{ $registration->join_date }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>مهام إضافية:</label>
                                    <p class="form-control-static">{{ $registration->additional_tasks ?: 'لا يوجد' }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>مواهب أو مهارات خاصة:</label>
                                    <p class="form-control-static">{{ $registration->special_skills ?: 'لا يوجد' }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>مشكلات في التواصل:</label>
                                    <p class="form-control-static">{{ $registration->communication_problems ?: 'لا يوجد' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>مشكلات خاصة:</label>
                                    <p class="form-control-static">{{ $registration->personal_problems ?: 'لا يوجد' }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>مهارات تحتاج تطويرها:</label>
                                    <p class="form-control-static">{{ $registration->skills_to_develop ?: 'لا يوجد' }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>رسالة خاصة للمستشار:</label>
                                    <p class="form-control-static">{{ $registration->message_to_consultant ?: 'لا يوجد' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- بيانات التواصل -->
                        <h5 class="section-title">بيانات التواصل</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم الجوال:</label>
                                    <p class="form-control-static">{{ $registration->mobile_number }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم الواتس آب:</label>
                                    <p class="form-control-static">{{ $registration->whatsapp_number ?: 'نفس رقم الجوال' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>البريد الإلكتروني:</label>
                                    <p class="form-control-static">{{ $registration->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            الإجراءات
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <!-- معلومات مقدم الطلب -->
                            <div class="mb-4">
                                <h5>معلومات مقدم الطلب</h5>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="symbol symbol-40 symbol-light-primary mr-3">
                                        <span class="symbol-label">
                                            <i class="flaticon2-user"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <a href="{{ route('getupdateuser', $registration->user_id) }}"
                                            class="text-dark font-weight-bold text-hover-primary">
                                            {{ $registration->user->user_name }}
                                        </a>
                                        <div class="text-muted">{{ $registration->user->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- تاريخ التقديم -->
                            <div class="mb-4">
                                <h5>تاريخ التقديم</h5>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="symbol symbol-40 symbol-light-info mr-3">
                                        <span class="symbol-label">
                                            <i class="flaticon2-calendar-1"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $registration->created_at->format('Y-m-d') }}
                                        </div>
                                        <div class="text-muted">{{ $registration->created_at->format('h:i A') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- أزرار الإجراءات -->
                            @if ($registration->status == 'pending')
                                <div class="d-flex flex-column">
                                    <a href="{{ route('registrations.approve', $registration->id) }}"
                                        class="btn btn-success btn-lg mb-3"
                                        onclick="return confirm('هل أنت متأكد من قبول هذا الطلب؟')">
                                        <i class="flaticon2-check-mark"></i> قبول الطلب
                                    </a>

                                    <button type="button" class="btn btn-danger btn-lg reject-btn"
                                        data-id="{{ $registration->id }}">
                                        <i class="flaticon2-cross"></i> رفض الطلب
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Rejection Reason -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="rejectForm" method="POST" action="{{ route('registrations.reject', $registration->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">رفض طلب التسجيل</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rejection_reason">سبب الرفض (اختياري)</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"></textarea>
                            <small class="form-text text-muted">سيتم إرسال هذا السبب إلى المتقدم.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // تعيين عنوان النموذج عند فتح نافذة الرفض
            $(document).on('click', '.reject-btn', function() {
                $('#rejectModal').modal('show');
            });
        });
    </script>
@endsection
