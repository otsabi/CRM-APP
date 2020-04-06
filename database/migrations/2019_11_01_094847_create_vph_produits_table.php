<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVphProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vph_produits', function (Blueprint $table) {
            $table->bigIncrements('pp_vph_id');
            $table->unsignedBigInteger('produit_id');
            $table->foreign('produit_id')->references('produit_id')->on('produits');
            $table->unsignedBigInteger('visitephar_id');
            $table->foreign('visitephar_id')->references('visitephar_id')->on('visite_pharmacies');
            $table->integer('nb_boites');
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
        Schema::dropIfExists('vph_produits');
    }
}
