<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBiayaTrans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_biaya_trans', function ($table) {
            $table->double('biaya_darat')->default(0)->after('id');
            $table->double('biaya_laut')->default(0)->after('biaya_darat');
            $table->unsignedBigInteger('created_by')->after('created_at');
            $table->unsignedBigInteger('updated_by')->after('updated_at');
            $table->dropColumn('pengguna_id');
            $table->dropColumn('tanggal');
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
