<?php

use App\Models\TrackInvestorFavorite;
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
        // lets just clear the table and start over
        TrackInvestorFavorite::truncate();

        Schema::table('track_investor_favorites', function (Blueprint $table) {
            $table->renameColumn('investor_name', 'name');
            $table->string('type');
            $table->string('identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('track_investor_favorites', function (Blueprint $table) {
            $table->renameColumn('name', 'investor_name');
            $table->dropColumn('identifier');
            $table->dropColumn('type');
        });
    }
};
