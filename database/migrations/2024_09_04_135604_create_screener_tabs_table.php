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
        Schema::create('screener_tabs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('universal_criteria')->nullable();
            $table->json('financial_criteria')->nullable();
            $table->json('summaries')->nullable();
            $table->json('views')->nullable();
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('screener_tabs');
    }
};
