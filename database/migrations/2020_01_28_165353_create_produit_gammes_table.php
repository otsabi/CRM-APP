<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduitGammesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_gammes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->foreign('produit_id')->references('produit_id')->on('produits')->onDelete('cascade');

            $table->unsignedBigInteger('gamme_id')->nullable();
            $table->foreign('gamme_id')->references('gamme_id')->on('gammes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produit_gammes');
    }
}
