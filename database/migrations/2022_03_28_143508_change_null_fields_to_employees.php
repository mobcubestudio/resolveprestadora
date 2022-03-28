<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullFieldsToEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('rg')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->date('birth_date')->nullable()->change();
            DB::statement("ALTER TABLE employees CHANGE COLUMN marital_status marital_status ENUM('S','C','V','D') NULL");
            $table->string('rg')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('rg')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->date('birth_date')->nullable(false)->change();
            DB::statement("ALTER TABLE employees CHANGE COLUMN marital_status marital_status ENUM('S','C','V','D') NOT NULL");
            $table->string('rg')->nullable(false)->change();
        });
    }
}
