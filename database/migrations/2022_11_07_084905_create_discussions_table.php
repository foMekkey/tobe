<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('discussions_user_id_foreign');
            $table->string('title', 191);
            $table->text('body');
            $table->tinyInteger('status');
            $table->text('attachment')->nullable();
            $table->string('attachment_type', 50)->nullable();
            $table->tinyInteger('privacy');
            $table->unsignedInteger('course_id')->nullable()->index('discussions_course_id_foreign');
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
        Schema::dropIfExists('discussions');
    }
}
