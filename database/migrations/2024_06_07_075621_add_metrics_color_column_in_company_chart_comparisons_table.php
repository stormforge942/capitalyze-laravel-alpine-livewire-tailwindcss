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
        Schema::table('company_chart_comparisons', function (Blueprint $table) {
            $table->json('metrics_color')->after('metric_attributes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_chart_comparisons', function (Blueprint $table) {
            $table->dropColumn('metrics_color');
        });
    }
};
