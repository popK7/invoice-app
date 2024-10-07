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
        Schema::create('invoice_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->string('order_id');
            $table->tinyInteger('payment_gateway')->default(1)->comment("1=>Stripe");
            $table->string('payment_method',30)->nullable();
            $table->string('card_holder_name',90)->nullable();
            $table->float('amount')->comment("USD");
            $table->string('amount_pay_currency',30)->comment("USD");
            $table->float('refund_amount')->nullable();
            $table->string('stripe_charge_id')->nullable()->comment("Stripe");
            $table->string('stripe_refund_id')->nullable()->comment("Stripe");
            $table->string('stripe_transaction_id')->nullable()->comment("Stripe");
            $table->tinyInteger('status')->comment("0=>Fail,1=>success");
            $table->foreign('invoice_id')->references('id')->on('invoice');
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
        Schema::dropIfExists('invoice_payment_details');
    }
};
