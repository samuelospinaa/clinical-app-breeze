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
        Schema::table('professionals', function (Blueprint $table) {
           $table->foreignId('user_id')
              ->nullable()
              ->after('professional_type')
              ->constrained()
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professionals', function (Blueprint $table) {
           $table->dropForeign('professionals_user_id_foreign');
           $table->dropColumn('user_id');
        });
    }
};
