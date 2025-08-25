<div class="form-group row">
    <label class="col-3 col-form-label">اسم الفوج <span class="text-danger">*</span></label>
    <div class="col-9">
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'أدخل اسم الفوج', 'required']) !!}
        @if ($errors->has('name'))
            <span class="form-text text-danger">{{ $errors->first('name') }}</span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-3 col-form-label">وصف الفوج</label>
    <div class="col-9">
        {!! Form::textarea('description', null, [
            'class' => 'form-control',
            'placeholder' => 'أدخل وصف الفوج',
            'rows' => 3,
        ]) !!}
        @if ($errors->has('description'))
            <span class="form-text text-danger">{{ $errors->first('description') }}</span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-3 col-form-label">تاريخ البداية <span class="text-danger">*</span></label>
    <div class="col-9">
        {!! Form::date(
            'start_date',
            isset($cohort) && $cohort->start_date ? $cohort->start_date->format('Y-m-d') : null,
            ['class' => 'form-control', 'required'],
        ) !!}
        @if ($errors->has('start_date'))
            <span class="form-text text-danger">{{ $errors->first('start_date') }}</span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-3 col-form-label">تاريخ النهاية <span class="text-danger">*</span></label>
    <div class="col-9">
        {!! Form::date('end_date', isset($cohort) && $cohort->end_date ? $cohort->end_date->format('Y-m-d') : null, [
            'class' => 'form-control',
            'required',
        ]) !!}
        @if ($errors->has('end_date'))
            <span class="form-text text-danger">{{ $errors->first('end_date') }}</span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label class="col-3 col-form-label">الحد الأقصى للمتدربين <span class="text-danger">*</span></label>
    <div class="col-9">
        {!! Form::number('max_trainees', isset($cohort) ? $cohort->max_trainees : 18, [
            'class' => 'form-control',
            'min' => 1,
            'max' => 50,
            'required',
        ]) !!}
        @if ($errors->has('max_trainees'))
            <span class="form-text text-danger">{{ $errors->first('max_trainees') }}</span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-3 col-form-label">الحالة <span class="text-danger">*</span></label>
    <div class="col-9">
        <div class="kt-radio-inline">
            <label class="kt-radio">
                {!! Form::radio('status', 1, true) !!} مفعل
                <span></span>
            </label>
            <label class="kt-radio">
                {!! Form::radio('status', 0) !!} غير مفعل
                <span></span>
            </label>
        </div>
        @if ($errors->has('status'))
            <span class="form-text text-danger">{{ $errors->first('status') }}</span>
        @endif
    </div>
</div>

<div class="kt-portlet__foot">
    <div class="kt-form__actions">
        <div class="row">
            <div class="col-3">
            </div>
            <div class="col-9">
                <button type="submit" class="btn btn-brand">حفظ</button>
                <a href="{{ route('cohorts.index') }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </div>
    </div>
</div>
