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
            Schema::create('doctors', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('doctor_id')->unsigned()->index()->nullable();
                $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('full_name');
                $table->string('phone_number');
                $table->string('city')->nullable();
                $table->string('qualifications')->nullable();
                $table->integer('patients_treated')->unsigned()->default(0);
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
        Schema::dropIfExists('doctors');
    }
};
