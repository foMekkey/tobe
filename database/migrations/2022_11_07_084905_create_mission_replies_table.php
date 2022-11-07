<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_replies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('mission_id')->index('mission_id');
            $table->integer('user_id')->index('user_id');
            $table->text('reply')->nullable();
            $table->string('file')->nullable();
            $table->boolean('trainer_rate')->nullable();
            $table->text('trainer_comment')->nullable();
            $table->boolean('status')->default(false)->comment('0: pending, 1:sent_and_waiting_review, 2: done');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_replies');
    }
}
