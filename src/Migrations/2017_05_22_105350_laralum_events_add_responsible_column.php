<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class LaralumEventsAddResponsibleColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laralum_event_user', function ($table) {
            $table->boolean('responsible')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laralum_event_user', function ($table) {
            $table->dropColumn('responsible');
        });
    }
}
