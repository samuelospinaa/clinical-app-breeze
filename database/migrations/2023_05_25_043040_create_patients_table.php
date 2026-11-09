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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('document_type');
            $table->bigInteger('document_number')->unique();
            $table->date('birthday')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->bigInteger('cellular')->nullable();
            $table->string('country')->nullable();
            $table->string('department')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('address_indications')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('profession')->nullable();
            $table->string('health_type')->nullable();
            $table->string('health_name')->nullable();
            $table->string('companion_name')->nullable();
            $table->bigInteger('companion_phone')->nullable();
            $table->string('companion_gender')->nullable();
            $table->string('companion_relationship')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
