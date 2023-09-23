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
        Schema::create('company_segment_reports', function (Blueprint $table) {
            $table->id();
            $table->decimal('previous_amount', 32)->default(0);
            $table->string('date')->default(0);
            $table->string('company_url')->nullable();
            $table->decimal('amount', 32)->default(0);
            $table->string('link')->nullable();
            $table->string('explanations')->nullable();
            $table->foreignId('user_id')->constrained('users')->nullOnDelete();
            $table->boolean('fixed')->default(false);
            $table->string('support_engineer')->nullable();
            $table->string('support_engineer_comments')->nullable();
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
        Schema::dropIfExists('company_segment_reports');
    }
};
