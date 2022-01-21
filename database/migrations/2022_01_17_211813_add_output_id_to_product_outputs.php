<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOutputIdToProductOutputs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_outputs', function (Blueprint $table) {
            $table->foreignId('output_id')->after('id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_outputs', function (Blueprint $table) {
            $table->dropForeign('product_outputs_output_id_foreign');
            $table->dropColumn('output_id');
        });
    }
}
