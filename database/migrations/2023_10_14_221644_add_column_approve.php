<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnApprove extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_transaksi_biaya', function (Blueprint $table) {
            $table->smallInteger('approved')->after('id')->default(0);
            $table->unsignedBigInteger('approved_by')->after('approved')->nullable();
            $table->timestamp('approved_at')->after('approved_by')->nullable();
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
