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
    public function up() {
        Schema::create('availability', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id');
            $table->date('unavailable_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availability');
    }
};
