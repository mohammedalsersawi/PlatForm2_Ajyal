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
        Schema::create('coaches', function (Blueprint $table) {
            // $table->integer('id')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('national_id');
            $table->integer('phone')->unique();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('address');
            $table->string('image')->nullable()->default('https://as2.ftcdn.net/v2/jpg/03/32/59/65/1000_F_332596535_lAdLhf6KzbW6PWXBWeIFTovTii1drkbT.jpg');
            $table->string('Specialization');
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
        Schema::dropIfExists('coaches');
    }
};
