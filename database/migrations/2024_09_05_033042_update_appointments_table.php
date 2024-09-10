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
        Schema::table('appointments', function (Blueprint $table) {
            // Verificar si la columna `schedule_id` no existe antes de agregarla
            if (!Schema::hasColumn('appointments', 'schedule_id')) {
                $table->unsignedBigInteger('schedule_id')->after('professional_id');
                $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            }

            // Eliminar la columna `is_booked` (si existe)
            if (Schema::hasColumn('appointments', 'is_booked')) {
                $table->dropColumn('is_booked');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Revertir los cambios
            $table->dropForeign(['schedule_id']);
            $table->dropColumn('schedule_id');

            // Volver a agregar la columna `is_booked`
            $table->boolean('is_booked')->default(false);
        });
    }
};
