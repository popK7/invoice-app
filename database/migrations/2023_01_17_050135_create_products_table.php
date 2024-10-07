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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->string('product_name');
            $table->unsignedBigInteger('category_id');
            $table->float('price');
            $table->unsignedBigInteger('color_id');
            $table->text('description');
            $table->text('product_image');
            $table->unsignedBigInteger('created_by');
            $table->tinyInteger('is_deleted')->default(0)->comment("0=>Active, 1=>Deleted");
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
