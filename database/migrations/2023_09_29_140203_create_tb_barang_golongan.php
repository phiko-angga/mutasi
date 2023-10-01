<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbBarangGolongan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_barang_golongan', function (Blueprint $table) {
            $table->id();
            $table->string('golongan',30);
            $table->integer('bujangan');
            $table->integer('keluarga');
            $table->integer('anak1');
            $table->integer('anak2');
            $table->integer('anak3');
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
        Schema::dropIfExists('tb_barang_golongan');
    }
}
