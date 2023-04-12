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
            $table->unsignedBigInteger('id')->primary();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->string('full_name');
            $table->string('phone_number');
            $table->decimal('rating', 2, 1)->unsigned()->nullable()->default(5.0);
            $table->string('image')->nullable();
            $table->string('clinic_address')->nullable();
            $table->string('qualifications')->nullable();
            $table->integer('price')->default(0);
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
