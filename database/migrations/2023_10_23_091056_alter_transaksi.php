<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_transaksi_biaya', function (Blueprint $table) {
            $table->text('ket_keberangkatan')->nullable()->change();
            $table->text('ket_tujuan')->nullable()->change();
            $table->string('mata_anggaran',50)->nullable()->change();
            $table->text('ket_lain2')->nullable()->change();
            $table->integer('rampung_beban_mak')->default(0)->nullable()->change();
            $table->date('rampung_tgl_pelunasan')->nullable()->change();
            $table->string('rampung_buktikas',250)->nullable()->change();
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
