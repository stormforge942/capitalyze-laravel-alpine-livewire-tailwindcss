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
            $table->json('locations')->nullable();
            $table->json('stock_exchanges')->nullable();
            $table->json('industries')->nullable();
            $table->json('currencies')->nullable();
            $table->json('sectors')->nullable();
            $table->json('decimal')->nullable();
            $table->json('summaries')->nullable();
            $table->json('selected_financial_criteria')->nullable();
            $table->string('screener_view_name');
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
