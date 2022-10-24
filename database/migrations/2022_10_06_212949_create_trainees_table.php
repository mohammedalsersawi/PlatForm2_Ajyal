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
        Schema::create('trainees', function (Blueprint $table) {
            // $table->integer('id')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->integer('national_id')->unique();
            $table->integer('phone')->unique();
            $table->string('address');
            $table->string('image')->nullable()->default('https://as2.ftcdn.net/v2/jpg/03/32/59/65/1000_F_332596535_lAdLhf6KzbW6PWXBWeIFTovTii1drkbT.jpg');
            $table->string('link')->nullable();
            $table->integer('job_number')->nullable();
            $table->integer('total_income')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('level', ['Featured', 'weak'])->nullable();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->primary('user_id');
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
        Schema::dropIfExists('trainees');
    }
};
