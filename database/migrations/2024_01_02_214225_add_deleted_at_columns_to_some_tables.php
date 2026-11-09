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
      if (!Schema::hasColumn('clinical_histories', 'deleted_at')) {
         Schema::table('clinical_histories', function (Blueprint $table) {
            $table->softDeletes()->after('patient_id');
         });
      }

      if (!Schema::hasColumn('history_patients', 'deleted_at')) {
         Schema::table('history_patients', function (Blueprint $table) {
            $table->softDeletes()->after('patient_id');
         });
      }

      if (!Schema::hasColumn('messages', 'deleted_at')) {
         Schema::table('messages', function (Blueprint $table) {
            $table->softDeletes()->after('content');
         });
      }

      if (!Schema::hasColumn('packs', 'deleted_at')) {
         Schema::table('packs', function (Blueprint $table) {
            $table->softDeletes()->after('description');
         });
      }

      if (!Schema::hasColumn('testimonies', 'deleted_at')) {
         Schema::table('testimonies', function (Blueprint $table) {
            $table->softDeletes()->after('body');
         });
      }
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      if (Schema::hasColumn('clinical_histories', 'deleted_at')) {
         Schema::table('clinical_histories', function (Blueprint $table) {
            $table->dropSoftDeletes();
         });
      }

      if (Schema::hasColumn('history_patients', 'deleted_at')) {
         Schema::table('history_patients', function (Blueprint $table) {
            $table->dropSoftDeletes();
         });
      }

      if (Schema::hasColumn('messages', 'deleted_at')) {
         Schema::table('messages', function (Blueprint $table) {
            $table->dropSoftDeletes();
         });
      }

      if (Schema::hasColumn('packs', 'deleted_at')) {
         Schema::table('packs', function (Blueprint $table) {
            $table->dropSoftDeletes();
         });
      }

      if (Schema::hasColumn('testimonies', 'deleted_at')) {
         Schema::table('testimonies', function (Blueprint $table) {
            $table->dropSoftDeletes();
         });
      }
   }
};
