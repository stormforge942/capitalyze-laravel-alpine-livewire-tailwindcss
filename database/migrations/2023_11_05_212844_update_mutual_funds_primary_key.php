<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mutual_funds', function (Blueprint $table) {
            $table->dropPrimary(['cik']);
            $table->primary(['cik', 'registrant_name', 'fund_symbol', 'series_id', 'class_id', 'class_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mutual_funds', function (Blueprint $table) {
            $table->dropPrimary(['cik', 'registrant_name', 'fund_symbol', 'series_id', 'class_id', 'class_name']);
            $table->primary(['cik']);
        });
    }
};
