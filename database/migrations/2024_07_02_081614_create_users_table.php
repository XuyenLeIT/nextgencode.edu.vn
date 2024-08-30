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
        //["name","email","password","phone","status","course_id"];
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->string("password");
            $table->string("phone");
            $table->string("role")->default("user");
            $table->boolean("status")->default(false);
            $table->string("class");
            $table->string("otp");
            $table->unsignedBigInteger("course_id")->nullable();
            $table->timestamps();
            // Thiết lập khóa ngoại và ràng buộc
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
