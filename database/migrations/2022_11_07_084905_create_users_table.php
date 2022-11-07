<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('f_name', 191)->nullable();
            $table->string('l_name', 191)->nullable();
            $table->string('user_name', 191)->nullable();
            $table->string('email', 191)->nullable()->unique();
            $table->string('password', 191)->nullable();
            $table->text('bio')->nullable();
            $table->text('certificates')->nullable();
            $table->string('image', 191)->nullable();
            $table->tinyInteger('type')->nullable();
            $table->text('tags')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('points')->nullable();
            $table->integer('role')->nullable()->default(0);
            $table->tinyInteger('badges_count')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->dateTime('last_login_at')->nullable();
            $table->string('last_login_ip', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
