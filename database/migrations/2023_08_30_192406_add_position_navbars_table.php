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
        Schema::table('navbars', function (Blueprint $table) {
            $table->integer('position')->default(0);
            $table->dropColumn(['show_users', 'show_developers', 'show_testers', 'show_admins']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('navbars', function (Blueprint $table) {
            $table->dropColumn(['position']);
            $table->boolean('show_users')->default(false);
            $table->boolean('show_developers')->default(false);
            $table->boolean('show_testers')->default(false);
            $table->boolean('show_admins')->default(false);
        });
    }
};
