<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_trainees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_attendance_id')->constrained('course_attendances')->cascadeOnDelete();
            $table->foreignId('trainee_id')->constrained('trainees')->cascadeOnDelete();
            $table->boolean('attendance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_trainees');
    }
};
