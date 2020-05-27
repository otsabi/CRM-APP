<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRapportMedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapport_meds', function (Blueprint $table) {
            $table->bigIncrements('rapport_med_id');
            $table->date('Date_de_visite');
            $table->string('Nom_Prenom');
            $table->string('Specialité');
            $table->string('Etablissement');
            $table->string('Potentiel')->nullable();
            $table->unsignedBigInteger('Montant_Inv_Précédents')->nullable();
            $table->string('Zone_Ville');

            $table->string('P1_présenté')->nullable();
            $table->string('P1_Feedback')->nullable();
            $table->integer('P1_Ech')->nullable();

            $table->string('P2_présenté')->nullable();
            $table->string('P2_Feedback')->nullable();
            $table->integer('P2_Ech')->nullable();

            $table->string('P3_présenté')->nullable();
            $table->string('P3_Feedback')->nullable();
            $table->integer('P3_Ech')->nullable();

            $table->string('P4_présenté')->nullable();
            $table->string('P4_Feedback')->nullable();
            $table->integer('P4_Ech')->nullable();

            $table->string('P5_présenté')->nullable();
            $table->string('P5_Feedback')->nullable();
            $table->integer('P5_Ech')->nullable();

            $table->string('Materiel_Promotion')->nullable();
            $table->string('Invitation_promise')->nullable();
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
        Schema::dropIfExists('rapport_meds');
    }
}
