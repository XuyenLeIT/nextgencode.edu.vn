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
        Schema::create('des_courses', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->boolean("status")->default(false);
            $table->unsignedBigInteger("course_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('des_courses');
    }
};
