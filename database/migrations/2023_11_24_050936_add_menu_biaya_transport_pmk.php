<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMenuBiayaTransportPmk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared("insert into tb_menu (id, nama, link, urutan, parent, grup, grup_urutan) values 
        (24, 'Biaya Transport PMK','biaya-transport-pmk',6,0,'DASAR PERHITUNGAN',3)");

        DB::unprepared("insert into tb_menu_user (pengguna_id, menu_id) values 
        (1, 24)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
