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
        Schema::create('etfs', function (Blueprint $table) {
            $table->string('cik');
            $table->string('registrant_name')->nullable();
            $table->string('etf_symbol');
            $table->timestamps();
            $table->unique(['cik', 'registrant_name', 'etf_symbol']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etfs');
    }
};
