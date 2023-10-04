<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTbLaut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_laut', function (Blueprint $table) {
            $table->unsignedBigInteger('kota_asal_id')->after('provinsi_asal_id')->nullable();
            $table->unsignedBigInteger('kota_tujuan_id')->after('provinsi_tujuan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_kota', function (Blueprint $table) {
            $table->dropColumn('kota_asal_id');
            $table->dropColumn('kota_tujuan_id');
        });
    }
}
