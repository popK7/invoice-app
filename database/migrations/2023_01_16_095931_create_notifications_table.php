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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_type_id');
            $table->string('title');
            $table->text('data')->nullable();
            $table->unsignedBigInteger('from_user');
            $table->unsignedBigInteger('to_user');
            $table->tinyInteger('is_read')->default(0)->comment("0=>not-read, 1=>read");
            $table->tinyInteger('is_deleted')->default(0)->comment("0=>Active, 1=>Deleted");
            $table->timestamps();
            $table->foreign('notification_type_id')->references('id')->on('notification_types');
            $table->foreign('from_user')->references('id')->on('users');
            $table->foreign('to_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
