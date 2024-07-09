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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->string('code');
            $table->timestamps();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id')->nullable()->after('status');
            $table->foreign('faculty_id')->references('id')->on('faculties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');

        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['faculty_id']);
            $table->dropColumn('faculty_id');
        });
    }
};
