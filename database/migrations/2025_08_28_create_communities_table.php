<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesTable extends Migration
{
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['course', 'cohort']);
            $table->unsignedBigInteger('reference_id'); // إما course_id أو cohort_id
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // فهرسة للبحث السريع
            $table->index(['type', 'reference_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('communities');
    }
}
