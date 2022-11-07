<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('meetings_user_id_foreign');
            $table->string('name', 191);
            $table->date('date');
            $table->string('time', 50);
            $table->text('message');
            $table->integer('period');
            $table->tinyInteger('meeting_with')->nullable()->comment('1: User, 2:Group');
            $table->integer('meeting_with_id')->nullable();
            $table->string('bbb_meeting_id', 50)->nullable();
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
        Schema::dropIfExists('meetings');
    }
}
