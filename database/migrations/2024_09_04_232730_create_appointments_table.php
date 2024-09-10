<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id'); // ID del profesional
            $table->string('patient_name')->nullable(); // Nombre del paciente (si está reservado)
            $table->dateTime('appointment_time');  // Fecha y hora de la cita
            $table->text('notes')->nullable();  // Notas adicionales del profesional o paciente
            $table->boolean('is_booked')->default(false); // Estado de la cita (si está reservada o no)
            $table->timestamps();

            // Relación con la tabla de profesionales (usuarios con rol de profesional)
            $table->foreign('professional_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
