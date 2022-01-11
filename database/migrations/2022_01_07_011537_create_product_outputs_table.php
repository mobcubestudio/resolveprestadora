<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('client_id')->constrained();
            $table->dateTime('date_time_order');
            $table->dateTime('date_time_selected');
            $table->dateTime('date_time_sent');
            $table->integer('amount');
            $table->enum('status',['P','S','E']); //P: Pedido, S: Separação, E: Enviado
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
        Schema::dropIfExists('product_outputs');
    }
}
