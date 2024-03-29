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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('time');
            $table->foreignId('courses_coach_id')->constrained('coaches' ,'user_id')->cascadeOnDelete();
            $table->string('image');
            $table->string('link')->nullable();
            $table->enum('classification', ['مدني', 'فري لانسر' , 'تقني']);
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
        Schema::dropIfExists('courses');
    }
};
