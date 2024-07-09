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
        Schema::create('grade_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->unsignedBigInteger('grade_type_id')->nullable()->after('course_id');
            $table->foreign('grade_type_id')->references('id')->on('grade_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['grade_type_id']);
            $table->dropColumn('grade_type_id');
        });
        Schema::dropIfExists('grade_types');
    }
};
