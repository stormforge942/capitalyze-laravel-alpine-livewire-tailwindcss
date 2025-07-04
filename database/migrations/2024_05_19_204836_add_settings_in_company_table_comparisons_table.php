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
        Schema::table('company_table_comparisons', function (Blueprint $table) {
            $table->json('settings')->nullable()->after('table_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_table_comparisons', function (Blueprint $table) {
            $table->dropColumn('settings');
        });
    }
};
