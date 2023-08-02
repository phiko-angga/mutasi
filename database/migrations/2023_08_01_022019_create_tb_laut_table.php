<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbLautTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_laut', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provinsi_asal_id');
            $table->unsignedBigInteger('pelabuhan_asal_id');
            $table->unsignedBigInteger('provinsi_tujuan_id');
            $table->unsignedBigInteger('pelabuhan_tujuan_id');
            $table->double('jarak_mil');
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
        Schema::dropIfExists('tb_laut');
    }
}
