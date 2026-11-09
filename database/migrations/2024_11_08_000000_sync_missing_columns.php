<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sincroniza columnas que el código usa pero que ninguna migración creaba
 * (se habían agregado a mano en la BD de producción). Cada cambio se
 * protege con hasColumn para poder correr también donde ya existen.
 */
return new class extends Migration
{
   public function up(): void
   {
      Schema::table('appointments', function (Blueprint $table) {
         if (!Schema::hasColumn('appointments', 'payment_method_id')) {
            $table->unsignedBigInteger('payment_method_id')->nullable();
         }
      });

      // payment_type fue reemplazado por payment_method_id; ya no se llena.
      if (Schema::hasColumn('appointments', 'payment_type')) {
         Schema::table('appointments', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->change();
         });
      }

      Schema::table('patients', function (Blueprint $table) {
         if (!Schema::hasColumn('patients', 'origin')) {
            $table->string('origin')->nullable();
         }
      });
   }

   public function down(): void
   {
      Schema::table('appointments', function (Blueprint $table) {
         if (Schema::hasColumn('appointments', 'payment_method_id')) {
            $table->dropColumn('payment_method_id');
         }
      });

      Schema::table('patients', function (Blueprint $table) {
         if (Schema::hasColumn('patients', 'origin')) {
            $table->dropColumn('origin');
         }
      });
   }
};
