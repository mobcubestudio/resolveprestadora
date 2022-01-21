<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->integer('ordered_by')->nullable();
            $table->dateTime('ordered_date_time')->nullable();
            $table->integer('selected_by')->nullable();
            $table->dateTime('selected_date_time')->nullable();
            $table->integer('sent_by')->nullable();
            $table->dateTime('sent_date_time')->nullable();
            $table->enum('status',['P','S','E'])->default('P')->comment('P: Pedido, S: Selecionado, E: Enviado');
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
        Schema::dropIfExists('outputs');
    }
}
