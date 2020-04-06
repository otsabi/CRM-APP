<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVmedProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vmed_produits', function (Blueprint $table) {
            $table->bigIncrements('pp_vsm_id');
            $table->unsignedBigInteger('visitemed_id');
            $table->foreign('visitemed_id')->references('visitemed_id')->on('visite_medicals');
            $table->unsignedBigInteger('produit_id');
            $table->foreign('produit_id')->references('produit_id')->on('produits');
            $table->unsignedBigInteger('feedback_id');
            $table->foreign('feedback_id')->references('feedback_id')->on('feedbacks');
            $table->integer('nbr_ech');
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
        Schema::dropIfExists('vmed_produits');
    }
}
