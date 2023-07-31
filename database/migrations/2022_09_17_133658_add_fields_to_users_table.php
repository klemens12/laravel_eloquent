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
        Schema::table('users', function (Blueprint $table) {
            $table->string('delivery_first_name', 555);
            $table->string('delivery_last_name', 555);
            $table->string('delivery_patronymic', 555);
            $table->string('delivery_counry', 555);
            $table->string('delivery_address', 555);
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('delivery_first_name');
            $table->dropColumn('delivery_last_name');
            $table->dropColumn('delivery_patronymic');
            $table->dropColumn('delivery_counry');
            $table->dropColumn('delivery_address');
            $table->dropColumn('delivery_phone');
            $table->dropColumn('delivery_zip');
        });
    }
};
