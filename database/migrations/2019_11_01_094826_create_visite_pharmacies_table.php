<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visite_pharmacies', function (Blueprint $table) {
            $table->bigIncrements('visitephar_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->string('etat');
            $table->date('date_visite');
            $table->unsignedBigInteger('pharmacie_id');
            $table->foreign('pharmacie_id')->references('pharmacie_id')->on('pharmacies');
            $table->text('note')->nullable();
            $table->string('valid')->default(0);
            $table->string('validated_by')->nullable();
            $table->string('validation_note')->nullable();
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
        Schema::dropIfExists('visite_pharmacies');
    }
}
