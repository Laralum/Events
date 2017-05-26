<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LaralumEventsAddPublicRoutesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laralum_events_settings', function (Blueprint $table) {
            $table->boolean('public_routes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laralum_events_settings', function (Blueprint $table) {
            $table->dropColumn('public_routes');
        });
    }
}
