<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransaksiBiayaId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tb_transaksi_biaya_muat', 'transaksi_biaya_id')) {
            Schema::table('tb_transaksi_biaya_muat', function (Blueprint $table) {
                $table->unsignedBigInteger('transaksi_biaya_id')->after('id')->nullable();
            });
        }

        if (!Schema::hasColumn('tb_transaksi_biaya_transport', 'transaksi_biaya_id')) {
            Schema::table('tb_transaksi_biaya_transport', function (Blueprint $table) {
                $table->unsignedBigInteger('transaksi_biaya_id')->after('id')->nullable();
            });
        }
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
