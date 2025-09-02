<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // تحقق مما إذا كانت الأعمدة موجودة بالفعل قبل إضافتها
            if (!Schema::hasColumn('notifications', 'type')) {
                $table->tinyInteger('type')->default(1)->after('message'); // 1: عادي، 2: رابط، إلخ
            }

            if (!Schema::hasColumn('notifications', 'link')) {
                $table->string('link')->nullable()->after('type');
            }

            // إذا كان عمود read_at غير موجود، قم بإضافته
            if (!Schema::hasColumn('notifications', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('link');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // إزالة الأعمدة في حالة التراجع عن الهجرة
            if (Schema::hasColumn('notifications', 'type')) {
                $table->dropColumn('type');
            }

            if (Schema::hasColumn('notifications', 'link')) {
                $table->dropColumn('link');
            }

            if (Schema::hasColumn('notifications', 'read_at')) {
                $table->dropColumn('read_at');
            }
        });
    }
}
