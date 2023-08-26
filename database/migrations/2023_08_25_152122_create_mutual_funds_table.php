<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMutualFundsTable extends Migration
{
public function up()
{
    Schema::table('mutual_funds', function (Blueprint $table) {
        $table->string('fund_symbol')->nullable();
        $table->string('series_id')->nullable();
        $table->string('class_id')->nullable();
    });
}

public function down()
{
    Schema::table('mutual_funds', function (Blueprint $table) {
        $table->dropColumn(['fund_symbol', 'series_id', 'class_id']);
    });
}
}
