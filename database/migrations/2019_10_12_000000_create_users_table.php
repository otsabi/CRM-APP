<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->foreign('ville_id')->references('ville_id')->on('villes')->onDelete('set null');
            $table->string('nom');
            $table->string('prenom');
            $table->string('title');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('tel')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('set null');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->foreign('manager_id')->references('user_id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('users');
    }
}
