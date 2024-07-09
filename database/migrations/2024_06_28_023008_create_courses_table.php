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
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('code');
            $table->string('sks');
            $table->enum('type', ['general', 'special']);
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable()->after('room_id');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
        });
    }
};
