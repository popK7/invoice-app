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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->text('app_title')->nullable();
            $table->text('light_logo')->nullable();
            $table->text('dark_logo')->nullable();
            $table->text('favicon')->nullable();
            $table->text('logo_sm')->nullable();
            $table->text('copyright_first')->nullable();
            $table->text('copyright_last')->nullable();
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
        Schema::dropIfExists('site_settings');
    }
};
