<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedTbPenggunaAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('tb_pengguna', function ($table) {
            $table->string('email',100)->nullable()->change();
        });

        DB::unprepared("insert into tb_pengguna(username,email,fullname,password,email_verified_at) select 'admin','admin@admin.com','Admin','$2a$12\$F/QhO.qmxf/mUNDmqYzbpu39aHj4CuKuid403LaISrJqYNS50.E/a', now()");

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
