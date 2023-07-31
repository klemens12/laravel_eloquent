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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            //$table->integer('product_id')->unsigned()->foreign('user_id')->references('id')->on('users');
            $table->integer('status_code')->unsigned();
            $table->string('email', 320);//64 characters for local part + @ + 255 for domain
            $table->string('delivery_first_name');
            $table->string('delivery_last_name');
            $table->string('delivery_patronymic');
            $table->string('delivery_counry');
            $table->string('delivery_address');
            $table->string('delivery_phone', 100);
            $table->string('delivery_zip', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
