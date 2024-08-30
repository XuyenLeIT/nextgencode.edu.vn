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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->date("startDate");
            $table->string("thumbnail");
            $table->float("duration");
            $table->boolean("typeLearn");
            $table->boolean("status")->default(false);
            $table->integer("dayweek");
            $table->integer("hourday");
            $table->string("stunumber");
            $table->string("class");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
