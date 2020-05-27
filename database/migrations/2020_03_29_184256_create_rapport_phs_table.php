<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRapportPhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapport_phs', function (Blueprint $table) {
            $table->bigIncrements('rapport_ph_id');
            $table->date('Date_de_visite');
            $table->string('pharmacie_zone');
            $table->string('Potentiel')->nullable();
            //$table->string('Zone_Ville');

            $table->string('P1_présenté')->nullable();
            $table->integer('P1_nombre_boites')->nullable();

            $table->string('P2_présenté')->nullable();
            $table->integer('P2_nombre_boites')->nullable();

            $table->string('P3_présenté')->nullable();
            $table->integer('P3_nombre_boites')->nullable();

            $table->string('P4_présenté')->nullable();
            $table->integer('P4_nombre_boites')->nullable();

            $table->string('P5_présenté')->nullable();
            $table->integer('P5_nombre_boites')->nullable();

            $table->string('Plan/Réalisé');
            //$table->string('Visite_Individuelle/Double')->nullable();;

            $table->string('DELEGUE');
            $table->integer('DELEGUE_id');

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
        Schema::dropIfExists('rapport_phs');
    }
}
