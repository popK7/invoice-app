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
        Schema::create('shipping_charge', function (Blueprint $table) {
            $table->id();
            $table->string('name',60);
            $table->string('country',60);
            $table->float('rate');
            $table->tinyInteger('status')->default(1)->comment("1=>Active, 0=>Disable");
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
        Schema::dropIfExists('shipping_charge');
    }
};
