<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPenggunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_pengguna', function ($table) {
            $table->string('fullname',80);
            $table->string('depname',80);
            $table->string('divname',80)->nullable();
            $table->string('secname',80)->nullable();
            $table->string('jabatan',80)->nullable();
            $table->string('catatan',80)->nullable();
            $table->string('kabkota',1)->default('N')->nullable();
            $table->string('tktsbum',1)->default('N')->nullable();
            $table->string('tktdhub',1)->default('N')->nullable();
            $table->string('tktbuska',1)->default('N')->nullable();
            $table->string('jrkdarat',1)->default('N')->nullable();
            $table->string('jrklaut',1)->default('N')->nullable();
            $table->string('mtsubah',1)->default('Y')->nullable();
            $table->string('mtsdele',1)->default('Y')->nullable();
            $table->string('mtslock',1)->default('Y')->nullable();
            $table->string('mtsprint',1)->default('Y')->nullable();
            $table->string('mtsekpor',1)->default('Y')->nullable();
            $table->string('aktif',5)->nullable();
            $table->string('appltype',1)->default('M')->nullable();
            $table->string('dtpegawai',1)->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pengguna');
    }
}
