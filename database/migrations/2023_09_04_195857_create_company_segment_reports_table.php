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
            $table->decimal('amount', 11)->default(0);
            $table->string('link')->nullable();
            $table->string('image_path')->nullable();
            $table->string('explanations')->nullable();
            $table->foreignId('user_id')->constrained('users')->nullOnDelete();
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
