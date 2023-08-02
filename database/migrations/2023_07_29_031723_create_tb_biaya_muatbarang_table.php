<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbBiayaMuatbarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_biaya_muatbarang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transportasi_id');
            $table->integer('berat');
            $table->double('tarif');
            $table->double('jumlah_biaya');
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
        Schema::dropIfExists('tb_biaya_muatbarang');
    }
}
