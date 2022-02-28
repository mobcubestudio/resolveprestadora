<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceivedToOutputs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outputs', function (Blueprint $table) {
            $table->integer('received_by')->after('sent_date_time')->nullable();
            $table->dateTime('received_date_time')->after('received_by')->nullable();
            $table->string('received_notes')->after('received_date_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outputs', function (Blueprint $table) {
            $table->dropColumn('received_by');
            $table->dropColumn('received_date_time');
            $table->dropColumn('received_notes');
        });
    }
}
