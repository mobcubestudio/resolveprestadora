<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DelProviderIdAndEmployeeIdAndPriceAndStatusToProductPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_purchases', function (Blueprint $table) {
            $table->dropForeign('product_purchases_provider_id_foreign');
            $table->dropColumn('provider_id');
            $table->dropForeign('product_purchases_employee_id_foreign');
            $table->dropColumn('employee_id');
            $table->dropColumn('price');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_purchases', function (Blueprint $table) {
            $table->foreignId('provider_id')->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->double('price',8,2);
            $table->enum('status',['P','E']); //P: Pedido, E: Entregue
        });
    }
}
