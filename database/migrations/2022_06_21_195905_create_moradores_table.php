<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moradores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf');
            $table->string('rg');
            $table->string('data_nascimento');
            $table->string('bloco');
            $table->string('apartamento');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
            $table->string('');
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
        Schema::dropIfExists('moradores');
    }
}
