<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTransaksiBiayaTransport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksi_biaya_transport', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_biaya_id');
            $table->tinyInteger('manual')->default(0);
            $table->tinyInteger('pembantu')->default(0);
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('kota_asal_id');
            $table->unsignedBigInteger('kota_tujuan_id');
            $table->integer('orang');
            $table->double('biaya_perorang')->default(0);
            $table->string('rinci_perkiraan',100)->nullable();
            $table->double('jumlah_biaya')->default(0);
            $table->string('metode',50);
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
        Schema::dropIfExists('tb_transaksi_biaya_transport');
    }
}
