<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTbKotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_kota', function ($table) {
            $table->string('kantor',1)->default('0');
            $table->string('ibukota_prov',1)->default('0');
            $table->string('bandara',1)->default('0');
            $table->string('pelabuhan',1)->default('0');
            $table->string('stasiun',1)->default('0');
            $table->string('terminal',1)->default('0');
            $table->string('alamat',250)->default('');
            $table->string('kodepos')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
