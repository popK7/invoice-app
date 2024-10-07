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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('invoice_number',30);
            $table->date('date');
            $table->tinyInteger('payment_status')->comment("0=>unpaid, 1=>paid ,2=>refund ,3=>cancel");
            $table->unsignedBigInteger('company_id');
            $table->string('billing_full_name',90);
            $table->longText('billing_address');
            $table->string('billing_mobile_number',30);
            $table->string('billing_tax_number',50)->nullable();
            $table->string('shippling_full_name',90);
            $table->longText('shippling_address');
            $table->string('shippling_mobile_number',30);
            $table->string('shippling_tax_number',50)->nullable();
            $table->tinyInteger('is_billing_shippling_add_same')->comment("0=>Different, 1=>Same");
            $table->float('sub_total',30);
            $table->float('tax',30);
            $table->float('discount',30);
            $table->float('shipping_charge',30);
            $table->float('total_amount',30);
            $table->unsignedBigInteger('created_by');
            $table->tinyInteger('is_deleted')->default(0)->comment("0=>Active, 1=>Deleted");
            $table->timestamps();
            
            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('company_details');
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
        Schema::dropIfExists('invoice');
    }
};
