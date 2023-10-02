<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PangkatGolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PangkatGolongan::insert([
            [
                'pangkat'	=> "Ad Hoc",
                'golongan'	=> "",
                'urutan'	=> 1,
            ],
            [
                'pangkat'	=> "Pembina Utama",
                'golongan'	=> "IV/e",
                'urutan'	=> 2,
            ],
            [
                'pangkat'	=> "Pembina Utama Madya",
                'golongan'	=> "IV/d",
                'urutan'	=> 3,
            ],
            [
                'pangkat'	=> "Pembina Utama Muda",
                'golongan'	=> "IV/c",
                'urutan'	=> 4,
            ],
            [
                'pangkat'	=> "Pembina Tk.I",
                'golongan'	=> "IV/b",
                'urutan'	=> 5,
            ],
            [
                'pangkat'	=> "Pembina",
                'golongan'	=> "IV/a",
                'urutan'	=> 6,
            ],
            [
                'pangkat'	=> "Penata Tk.I",
                'golongan'	=> "III/d",
                'urutan'	=> 7,
            ],
            [
                'pangkat'	=> "Penata",
                'golongan'	=> "III/c",
                'urutan'	=> 8,
            ],
            [
                'pangkat'	=> "Penata Muda Tk.I",
                'golongan'	=> "III/b",
                'urutan'	=> 9,
            ],
            [
                'pangkat'	=> "Penata Muda",
                'golongan'	=> "III/a",
                'urutan'	=> 10,
            ],
            [
                'pangkat'	=> "Pengatur Tk.I",
                'golongan'	=> "II/d",
                'urutan'	=> 11,
            ],
            [
                'pangkat'	=> "Pengatur",
                'golongan'	=> "II/c",
                'urutan'	=> 12,
            ],
            [
                'pangkat'	=> "Pengatur Muda Tk.1",
                'golongan'	=> "II/b",
                'urutan'	=> 13,
            ],
            [
                'pangkat'	=> "Pengatur Muda",
                'golongan'	=> "II/a",
                'urutan'	=> 14,
            ],
        ]);
    }
}
