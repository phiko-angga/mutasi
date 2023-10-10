<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Table::insert([
            [
                'kode'	=> "Table 11",
                'deskripsi'	=> "Maluku Bagian Tengah",
            ],
            [
                'kode'	=> "Table 12",
                'deskripsi'	=> "Maluku Bagian Selatan",
            ],
            [
                'kode'	=> "Table 13",
                'deskripsi'	=> "Bali dan Kepulauan Nusa Tenggara",
            ],
            [
                'kode'	=> "Table 14",
                'deskripsi'	=> "Papua Bagian Utara",
            ],
            [
                'kode'	=> "Table 15",
                'deskripsi'	=> "Papua Bagian Selatan",
            ],
        ]);
    }
}
