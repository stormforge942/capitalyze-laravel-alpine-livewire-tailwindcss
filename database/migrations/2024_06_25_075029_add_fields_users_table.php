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
        Schema::table('users', function (Blueprint $table) {
            $table->string('job')->nullable()->after('email');
            $table->date('dob')->nullable()->after('job');
            $table->string('country')->nullable()->after('dob');
            $table->string('facebook_link')->nullable()->after('linkedin_link');
            $table->string('twitter_link')->nullable()->after('linkedin_link');
            $table->string('two_factor_email')->nullable()->after('two_factor_confirmed_at');
            $table->integer('two_factor_code')->nullable()->after('two_factor_confirmed_at');
            $table->timestamp('two_factor_expires_at')->nullable()->after('two_factor_confirmed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('job');
            $table->dropColumn('dob');
            $table->dropColumn('country');
            $table->dropColumn('facebook_link');
            $table->dropColumn('twitter_link');
            $table->dropColumn('two_factor_email');
            $table->dropColumn('two_factor_code');
            $table->dropColumn('two_factor_expires_at');
        });
    }
};
