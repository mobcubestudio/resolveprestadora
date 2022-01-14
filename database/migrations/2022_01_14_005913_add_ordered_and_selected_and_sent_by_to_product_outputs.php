<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderedAndSelectedAndSentByToProductOutputs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_outputs', function (Blueprint $table) {
            $table->string('ordered_by')->nullable()->after('client_id');
            $table->string('selected_by')->nullable()->after('date_time_order');
            $table->string('sent_by')->nullable()->after('date_time_selected');
            $table->dateTime('date_time_order')->nullable()->change();
            $table->dateTime('date_time_selected')->nullable()->change();
            $table->dateTime('date_time_sent')->nullable()->change();
            $table->dropForeign('product_outputs_employee_id_foreign');
            $table->dropColumn('employee_id');
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
            $table->dropPrimary('ordered_by');
            $table->dropPrimary('selected_by');
            $table->dropPrimary('sent_by');
        });
    }
}
