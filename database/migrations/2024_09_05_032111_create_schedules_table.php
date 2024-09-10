<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id'); // Relación con el profesional
            $table->date('available_date'); // Fecha disponible
            $table->time('start_time'); // Hora de inicio
            $table->time('end_time'); // Hora de fin
            $table->boolean('is_booked')->default(false); // Si está reservada o no
            $table->timestamps();

            $table->foreign('professional_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
