<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->tinyInteger('type');
            $table->integer('user_id')->index('user_id');
            $table->text('message');
            $table->tinyInteger('related_type');
            $table->integer('related_id')->index('related_id');
            $table->timestamp('datetime')->nullable()->useCurrent();
            $table->timestamp('read_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_notifications');
    }
}
