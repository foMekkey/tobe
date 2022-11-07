<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('owner_type', 191)->nullable();
            $table->integer('owner_id')->nullable();
            $table->string('extension', 20);
            $table->text('local_path')->nullable();
            $table->integer('file_size');
            $table->string('mime', 191);
            $table->string('thumbnail', 191)->nullable();
            $table->text('url')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->string('name', 191);
            $table->unsignedInteger('user_id')->nullable()->index('files_user_id_foreign');
            $table->integer('group_id')->nullable();
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
        Schema::dropIfExists('files');
    }
}
