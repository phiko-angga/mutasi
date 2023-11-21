<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColTrxbiaya extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if (!Schema::hasColumn('tb_transaksi_biaya', 'pejabat_komitmen')) {
            Schema::table('tb_transaksi_biaya', function (Blueprint $table) {
                $table->string('pejabat_komitmen',100)->default('SEKRETARIAT DITJEN BADAN PERADILAN UMUM')->nullable();
            });
        }
        
        if (Schema::hasColumn('tb_transaksi_biaya', 'tanggal_berangkat')) {
            Schema::table('tb_transaksi_biaya', function (Blueprint $table) {
                $table->string('tanggal_berangkat',40)->default('')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('tb_transaksi_biaya', 'tanggal_kembali')) {
            Schema::table('tb_transaksi_biaya', function (Blueprint $table) {
                $table->string('tanggal_kembali',40)->default('')->nullable()->change();
            });
        }

        if (Schema::hasColumn('tb_transaksi_biaya', 'pejabat_komitmen_id')) {
            Schema::table('tb_transaksi_biaya', function (Blueprint $table) {
                $table->unsignedBigInteger('pejabat_komitmen_id')->nullable()->change();
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
