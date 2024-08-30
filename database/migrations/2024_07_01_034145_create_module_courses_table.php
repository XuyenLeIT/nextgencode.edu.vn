<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('module_courses', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->unsignedBigInteger("course_id");
            $table->boolean("status");
            $table->integer("stt");
            $table->timestamps();
             // Thiết lập khóa ngoại và ràng buộc
             $table->foreign('course_id')->references('id')->on('courses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_courses');
    }
};
