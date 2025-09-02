<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsV2ToNotificationsTable extends Migration
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
            if (!Schema::hasColumn('notifications', 'user_id')) {
                $table->unsignedInteger('user_id');
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
            if (Schema::hasColumn('notifications', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
}