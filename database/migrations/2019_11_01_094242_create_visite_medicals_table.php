<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisiteMedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visite_medicals', function (Blueprint $table) {
            $table->bigIncrements('visitemed_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->string('etat');
            $table->date('date_visite');
            $table->unsignedBigInteger('medecin_id');
            $table->foreign('medecin_id')->references('medecin_id')->on('medecins');
            $table->integer('valid')->nullable()->default(null);
            $table->string('validated_by')->nullable();
            $table->string('validation_note')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('visite_medicals');
    }
}
