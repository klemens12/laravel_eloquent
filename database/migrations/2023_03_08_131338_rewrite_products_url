<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function __construct() {
        $this->table_name = 'media';
        $this->field_name = 'url';
    }
   
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->string($this->field_name)->nullable()->change();
            DB::statement("UPDATE ". $this->table_name . " SET " . $this->field_name . " = REPLACE(" . $this->field_name . ", '/storage/app/public/products', '')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table($this->table_name, function (Blueprint $table) {
            $table->string($this->field_name)->nullable()->change();
            DB::statement("UPDATE ". $this->table_name . " SET " . $this->field_name . " = REPLACE(" . $this->field_name . ", '/', '/storage/app/public/products/')");
        });
    }
};
