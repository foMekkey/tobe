#!/bin/bash

# سكربت لتنفيذ Laravel migration مع عدّ الأخطاء وتجاوزها

echo "🔁 بدء عملية الـ migrate..."
echo "-----------------------------"

ERROR_COUNT=0
TOTAL_COUNT=0

# جلب كل ملفات المايجريشن
FILES=$(ls database/migrations/*.php)

for FILE in $FILES; do
    ((TOTAL_COUNT++))

    # محاولة تنفيذ كل ملف لوحده باستخدام migrate:run
    echo "🚀 محاولة تنفيذ: $FILE"

    php artisan migrate --path=$FILE --force

    if [ $? -ne 0 ]; then
        echo "❌ فشل تنفيذ $FILE"
        ((ERROR_COUNT++))
    else
        echo "✅ تم تنفيذ $FILE بنجاح"
    fi

    echo "-----------------------------"
done

echo ""
echo "📊 تقرير العملية:"
echo "🔢 إجمالي الملفات: $TOTAL_COUNT"
echo "❗ عدد الملفات التي فشلت: $ERROR_COUNT"

if [ "$ERROR_COUNT" -eq 0 ]; then
    echo "🎉 تم تنفيذ جميع الـ migrations بنجاح!"
else
    echo "⚠️ يوجد بعض الأخطاء، راجع أعلاه للمزيد من التفاصيل."
fi
