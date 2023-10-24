<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTarifTransaksiBiayaMuat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tb_transaksi_biaya_muat', 'tarif')) {
            Schema::table('tb_transaksi_biaya_muat', function (Blueprint $table) {
                $table->double('tarif')->default(0)->nullable();
            });
        }
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
