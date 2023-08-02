<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_sbum', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provinsi_asal_id');
            $table->unsignedBigInteger('kota_asal_id');
            $table->unsignedBigInteger('provinsi_tujuan_id');
            $table->unsignedBigInteger('kota_tujuan_id');
            $table->double('harga_tiket');
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
        Schema::dropIfExists('tb_sbum');
    }
}
