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
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->string('company_name',90);
            $table->string('website',90);
            $table->string('email',50);
            $table->string('invoice_slug',20);
            $table->bigInteger('mobile_number')->unsigned();
            $table->bigInteger('postalcode')->unsigned();
            $table->longText('address');
            $table->text('logo');
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
        Schema::dropIfExists('company_details');
    }
};
