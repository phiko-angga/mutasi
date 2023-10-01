<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_table', function (Blueprint $table) {
            $table->id();
            $table->string('kode',15);
            $table->string('deskripsi',50);
            $table->timestamps();
        });

        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 01','Sumatera, Pantai Barat Bagian Selatan'");
        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 02','Sumatera, Pantai Barat Dan Aceh Bagian Utara'");
        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 03','Sumatera, Pantai Timur Bagian Selatan'");
        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 04','Sumatera, Pantai Timur Bagian Utara'");
        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 05','Kalimantan Dan Makasar'");
        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 06','Kalimantan, Pantai Selatan Dan Tenggara'");
        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 07','Selat Makasar'");
        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 08','Sulawesi Dan Kepulauan Flores Bagian Selatan'");
        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 09','Sulawesi Dan Teluk Tomoni Bagian Timur'");
        DB::unprepared("insert into tb_table(kode,deskripsi) select 'Table 10','Sulawesi Dan Maluku Bagian Utara'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_table');
    }
}
