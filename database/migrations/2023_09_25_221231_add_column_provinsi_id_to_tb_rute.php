<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProvinsiIdToTbRute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_rute', function (Blueprint $table) {
            $table->unsignedBigInteger('provinsi_id')->after('kode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_rute', function (Blueprint $table) {
            $table->dropColumn('provinsi_id');
        });
    }
}
