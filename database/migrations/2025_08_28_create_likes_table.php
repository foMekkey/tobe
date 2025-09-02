<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->morphs('likeable'); // يمكن أن يكون post أو comment
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // لضمان عدم تكرار الإعجاب
            $table->unique(['likeable_type', 'likeable_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
