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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->integer('national_id');
            $table->integer('phone');
            $table->string('address');
            $table->string('image');
            $table->string('link')->nullable();
            $table->integer('job_number')->nullable();
            $table->integer('total_income')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('level', ['Featured', 'weak'])->nullable();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->enum('account_status', ['active', 'archived'])->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
