<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('mutual_funds')->truncate();

        Schema::table('mutual_funds', function (Blueprint $table) {
            $table->string('class_name')->nullable()->after('class_id');
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
            $table->dropColumn('class_name');
        });
    }
};
