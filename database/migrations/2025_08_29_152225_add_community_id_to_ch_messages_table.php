<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommunityIdToChMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('community_id')->nullable()->after('id');
            $table->foreign('community_id')->references('id')->on('cohorts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->dropForeign(['community_id']);
            $table->dropColumn('community_id');
        });
    }
}