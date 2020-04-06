<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedecinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medecins', function (Blueprint $table) {
            $table->bigIncrements('medecin_id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('adresse');
            $table->string('tel')->nullable();
            $table->string('etablissement');
            $table->string('potentiel')->nullable();
            $table->string('zone_med');
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->foreign('ville_id')->references('ville_id')->on('villes')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');;
            $table->unsignedBigInteger('specialite_id')->nullable();
            $table->foreign('specialite_id')->references('specialite_id')->on('specialites')->onDelete('set null');
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
        Schema::dropIfExists('medecins');
    }
}
