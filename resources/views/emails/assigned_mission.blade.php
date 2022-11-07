مرحبا: {{ $user->f_name . ' ' . $user->l_name }}<br>
لقد تم تخصيص مهمة جديدة لك بعنوان: {{ $mission->name }}<br>
وصف المهمة: {!! nl2br($mission->desc) !!}<br>
تاريخ التسليم: {{ $mission->expire_date->format('d/m/Y') }}
<br><br>
تقبل تحياتنا<br>
فريق ToBe