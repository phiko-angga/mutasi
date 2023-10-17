<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTbTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('tb_transaksi_biaya', 'rampung_kuasa_nama')) {
            Schema::table('tb_transaksi_biaya', function (Blueprint $table) {
                $table->string('rampung_kuasa_nama',100)->after('id')->nullable()->change();
            });
        }
        if (!Schema::hasColumn('tb_transaksi_biaya', 'rampung_kuasa_nip')) {
            Schema::table('tb_transaksi_biaya', function (Blueprint $table) {
                $table->string('rampung_kuasa_nip',50)->nullable()->after('id');
            });
        }
        if (!Schema::hasColumn('tb_transaksi_biaya', 'rampung_kuasa')) {
            Schema::table('tb_transaksi_biaya', function (Blueprint $table) {
                $table->smallInteger('rampung_kuasa')->after('id')->default(0);
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
