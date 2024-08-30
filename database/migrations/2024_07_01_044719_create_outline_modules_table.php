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
        Schema::create('outline_modules', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("description");
            $table->boolean("status");
            $table->unsignedBigInteger("module_id");
            $table->timestamps();
            // Thiết lập khóa ngoại và ràng buộc
            $table->foreign('module_id')->references('id')->on('module_courses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outline_modules');
    }
};
