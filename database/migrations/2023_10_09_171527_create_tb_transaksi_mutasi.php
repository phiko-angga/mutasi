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
            $table->string('nomor',30);
            $table->unsignedBigInteger('pejabat_komitmen_id');
            $table->string('pegawai_diperintah',50);
            $table->string('nip',30);
            $table->unsignedBigInteger('pangkat_golongan_id');
            $table->string('jabatan_instansi',50);
            $table->unsignedBigInteger('kelompok_jabatan_id');
            $table->string('tingkat_perj_dinas',100);
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('kota_asal_id');
            $table->text('ket_keberangkatan');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
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
            $table->unsignedBigInteger('pejabat_komitmen_nama');
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
