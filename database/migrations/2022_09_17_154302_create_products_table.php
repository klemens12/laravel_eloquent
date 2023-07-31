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
            $table->timestamps();
            //$table->integer('category_id');
            $table->integer('user_id')->unsigned()->foreign('user_id')->references('id')->on('users');
            $table->text('product_name');
            $table->text('product_image');
            $table->text('product_url');
            $table->text('product_text');
            $table->string('meta_title', 70);
            $table->string('meta_descr', 160);
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
