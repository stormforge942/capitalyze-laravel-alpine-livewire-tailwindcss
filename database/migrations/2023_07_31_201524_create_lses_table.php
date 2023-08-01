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
        Schema::create('lses', function (Blueprint $table) {
            $table->string('symbol')->primary();
            $table->string('registrant_name')->nullable();
            $table->string('market')->nullable();
            $table->string('market_segment')->nullable();
            $table->string('share_register_country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lses');
    }
};
