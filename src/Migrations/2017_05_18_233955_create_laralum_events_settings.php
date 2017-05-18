<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laralum\Events\Models\Settings;

class CreateLaralumEventsSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laralum_events_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text_editor');
            $table->string('public_url');
            $table->timestamps();
        });

        Settings::create([
            'text_editor' => 'markdown',
            'public_url'  => 'events',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laralum_events_settings');
    }
}
