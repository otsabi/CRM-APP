<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->bigIncrements('pharmacie_id');
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->foreign('ville_id')->references('ville_id')->on('villes')->onDelete('set null');
            $table->string('libelle');
            $table->string('tel')->nullable();
            $table->text('adresse')->nullable();
            $table->string('zone_ph');
            $table->string('potentiel')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->string('valid');
            $table->string('created_by');
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
        Schema::dropIfExists('pharmacies');
    }
}
