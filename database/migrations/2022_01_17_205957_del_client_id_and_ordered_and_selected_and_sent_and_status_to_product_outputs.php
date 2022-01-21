<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DelClientIdAndOrderedAndSelectedAndSentAndStatusToProductOutputs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_outputs', function (Blueprint $table) {
            /*$table->dropForeign('product_outputs_client_id_foreign');
            $table->dropColumn('client_id');
            $table->dropColumn('ordered_by');
            $table->dropColumn('date_time_order');
            $table->dropColumn('selected_by');
            $table->dropColumn('date_time_selected');
            $table->dropColumn('sent_by');
            $table->dropColumn('date_time_sent');
            $table->dropColumn('status');*/
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
            $table->foreignId('client_id')->constrained();
            $table->string('ordered_by')->nullable();
            $table->string('selected_by')->nullable();
            $table->string('sent_by')->nullable();
            $table->dateTime('date_time_order')->nullable();
            $table->dateTime('date_time_selected')->nullable();
            $table->dateTime('date_time_sent')->nullable();
        });
    }
}
