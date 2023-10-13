<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTransaksiBiayaKeluarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksi_biaya_keluarga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_biaya_id');
            $table->tinyInteger('biaya_perj_dinas')->default(0);
            $table->string('nama',50);
            $table->date('tanggal_lahir');
            $table->integer('umur');
            $table->enum('keterangan',['Istri','Suami','AK','AA']);
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
        Schema::dropIfExists('tb_transaksi_biaya_keluarga');
    }
}
