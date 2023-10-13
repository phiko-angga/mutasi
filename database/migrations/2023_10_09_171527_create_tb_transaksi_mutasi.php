<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTransaksiMutasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksi_biaya', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->string('nomor',30);
            $table->string('pegawai_diperintah',50);
            $table->string('jabatan_instansi',50);
            $table->string('nip',30);
            $table->unsignedBigInteger('pejabat_komitmen_id');
            $table->unsignedBigInteger('pejabat_komitmen2_id');
            $table->unsignedBigInteger('pangkat_golongan_id');
            $table->unsignedBigInteger('kelompok_jabatan_id');
            $table->string('tingkat_perj_dinas',100);
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('kota_asal_id');
            $table->text('ket_keberangkatan');
            $table->string('lama_perj_dinas',50);
            $table->unsignedBigInteger('kota_tujuan_id');
            $table->text('ket_tujuan');
            $table->string('status_perkawinan',50);
            $table->string('maksud_perj_dinas',250);
            $table->integer('jumlah_pengikut');
            $table->tinyInteger('pembantu_ikut')->default(0);
            $table->string('pembebanan_anggaran',100);
            $table->string('mata_anggaran',50);
            $table->text('ket_lain2');
            $table->integer('pengepakan_berat')->default(0);
            $table->unsignedBigInteger('pengepakan_transport_id');
            $table->double('pengepakan_tarif')->default(0);
            $table->double('pengepakan_biaya')->default(0);
            $table->integer('uangh_jml_orang')->default(0);
            $table->integer('uangh_jml_hari')->default(0);
            $table->double('uangh_jml_tarif')->default(0);
            $table->double('uangh_jml_biaya')->default(0);
            $table->integer('uangh_jml_pembantu')->default(0);
            $table->integer('uangh_jml_hari_p')->default(0);
            $table->double('uangh_jml_tarif_p')->default(0);
            $table->double('uangh_jml_biaya_p')->default(0);
            $table->double('uangh_jml_uang')->default(0);
            $table->string('uangh_jml_terbilang',250)->default('');
            $table->double('rampung_jumlah')->default(0);
            $table->double('rampung_dibayar')->default(0);
            $table->double('rampung_sisa')->default(0);
            $table->double('rampung_beban_mak')->default(0);
            $table->string('rampung_buktikas',250)->default('');
            $table->date('rampung_tgl_pelunasan');
            $table->integer('rampung_thn_anggaran');
            $table->unsignedBigInteger('rampung_bendaharawan_id');
            $table->unsignedBigInteger('rampung_kuasa_nama');
            $table->unsignedBigInteger('rampung_ppk_id');
            $table->unsignedBigInteger('rampung_anggaran_id');
            $table->text('rampung_rincian')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
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
        Schema::dropIfExists('tb_transaksi_biaya');
    }
}
