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
        Schema::create('company_table_comparisons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('companies');
            $table->json('metrics');
            $table->json('summaries');
            $table->json('notes');
            $table->json('table_order');
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
        Schema::dropIfExists('company_table_comparisons');
    }
};
