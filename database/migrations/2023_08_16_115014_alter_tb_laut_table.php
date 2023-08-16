<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTbLautTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('tb_laut', function ($table) {
            $table->string('pelabuhan_asal',250)->default('');
            $table->string('pelabuhan_tujuan',250)->default('');
            $table->string('nama_table',250)->default('');
            $table->dropColumn('pelabuhan_asal_id');
            $table->dropColumn('pelabuhan_tujuan_id');
        });
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
