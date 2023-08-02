<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTandatanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_tandatangan', function (Blueprint $table) {
            $table->id();
            $table->string('kelompok');
            $table->integer('nourut')->length(5);
            $table->string('nama',100);
            $table->string('nip',100);
            $table->string('pangkat');
            $table->string('jabatan',100);
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
        Schema::dropIfExists('tb_tandatangan');
    }
}
