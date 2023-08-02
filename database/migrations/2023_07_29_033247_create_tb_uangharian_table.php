<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbUangharianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_uangharian', function (Blueprint $table) {
            $table->id();
            $table->integer('jml_orang');
            $table->integer('jml_hari');
            $table->double('tarif');
            $table->double('jumlah_biaya');
            $table->integer('pembantu');
            $table->integer('pembantu_jml_hari');
            $table->double('pembantu_tarif');
            $table->double('pembantu_jumlah_biaya');
            $table->double('total_biaya');
            $table->double('total_dibayar');
            $table->double('total_selisih');
            $table->date('tgl_pelunasan');
            $table->string('beban_mak');
            $table->string('bukti_kas',150);
            $table->string('tahun_anggaran',10);
            $table->string('bendaharawan_nama',100);
            $table->string('bendaharawan_nip',100);
            $table->string('penerimakuasa_nama',100);
            $table->string('penerimakuasa_nip',100);
            $table->string('ppk_nama',100);
            $table->string('ppk_nip',100);
            $table->string('kpa_nama',100);
            $table->string('kpa_nip',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_uangharian');
    }
}
