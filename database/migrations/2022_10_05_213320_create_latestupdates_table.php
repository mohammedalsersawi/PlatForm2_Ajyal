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
        Schema::create('latestupdates', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->string('details');
            $table->date('sending_date');
            $table->date('start_date');
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
        Schema::dropIfExists('latestupdates');
    }
};
