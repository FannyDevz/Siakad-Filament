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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip');
            $table->string('gender');
            $table->string('birthplace')->nullable();
            $table->date('birthdate');
            $table->string('religion')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id')->nullable()->after('department_id');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id')->nullable()->after('room_id');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');

        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }
};
