<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBiayaMuatbarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('tb_biaya_muatbarang', function ($table) {
            $table->double('biaya_darat')->default(0)->after('id');
            $table->double('biaya_laut')->default(0)->after('biaya_darat');
            $table->string('jawamadura',1)->default('0')->after('biaya_darat');
            $table->unsignedBigInteger('created_by')->after('created_at');
            $table->unsignedBigInteger('updated_by')->after('updated_at');
            $table->dropColumn('transportasi_id');
            $table->dropColumn('berat');
            $table->dropColumn('tarif');
            $table->dropColumn('jumlah_biaya');
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
