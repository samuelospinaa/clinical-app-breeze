<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('appointments', function (Blueprint $table) {
         $table->id();
         $table->bigInteger('price');
         $table->string('payment_type');

         $table->foreignId('service_id')
            ->constrained()
            ->onDelete('cascade');

         $table->date('date');
         $table->time('start_time');
         $table->time('end_time');

         $table->foreignId('patient_id')
            ->constrained()
            ->onDelete('cascade');

         $table->foreignId('professional_id')
            ->constrained()
            ->onDelete('cascade');

         $table->text('notes')->nullable();
         $table->boolean('attended')->default(0);

         $table->softDeletes();
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
      Schema::dropIfExists('appointments');
   }
};
