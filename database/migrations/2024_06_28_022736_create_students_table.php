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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nis');
            $table->string('gender');
            $table->string('birthplace');
            $table->date('birthdate');
            $table->string('religion')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->enum('status', ['active', 'inactive']);
            $table->date( 'admission_date');
            $table->date( 'graduation_date')->default('0000-00-00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
