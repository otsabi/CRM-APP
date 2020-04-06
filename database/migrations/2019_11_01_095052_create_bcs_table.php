<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bcs', function (Blueprint $table) {
            $table->bigIncrements('bc_id');
            $table->unsignedBigInteger('medecin_id');
            $table->foreign('medecin_id')->references('medecin_id')->on('medecins');
            $table->date('date_demande');
            $table->date('date_realisation');
            $table->string('type');
            $table->string('destination')->nullable();
            $table->text('detail');
            $table->float('montant');
            $table->string('etat');
            $table->string('satisfaction')->nullable();
            $table->string('engagement')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->string('created_by');
            $table->string('validated_by')->default(null)->nullable();
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
        Schema::dropIfExists('bcs');
    }
}
