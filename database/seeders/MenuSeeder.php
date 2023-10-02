<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Menu::insert([
            [
                'nama'	=> "Biaya",
                'link'	=> "dashboard_biaya",
                'urutan'	=> 1,
                'parent'	=> 0,
                'grup'	=> "DASHBOARD",
                'grup_urutan'	=> 1
            ],
            [
                'nama'	=> "Mutasi Per Tahun / Graphic Bulanan",
                'link'	=> "dashboard_mutasi",
                'urutan'	=> 2,
                'parent'	=> 0,
                'grup'	=> "DASHBOARD",
                'grup_urutan'	=> 1
            ],
            [
                'nama'	=> "Jumlah Biaya Yg Dikeluarkan Dlm Tahunan",
                'link'	=> "dashboard_biaya",
                'urutan'	=> 3,
                'parent'	=> 0,
                'grup'	=> "DASHBOARD",
                'grup_urutan'	=> 1
            ],
            [
                'nama'	=> "Search No SK Untuk Cari Biaya Yg Dikeluarkan",
                'link'	=> "dashboard_nosk",
                'urutan'	=> 4,
                'parent'	=> 0,
                'grup'	=> "DASHBOARD",
                'grup_urutan'	=> 1
            ],
            [
                'nama'	=> "Biaya",
                'link'	=> "transaksi-biaya",
                'urutan'	=> 1,
                'parent'	=> 0,
                'grup'	=> "TRANSAKSI",
                'grup_urutan'	=> 2
            ],
            [
                'nama'	=> "Mutasi",
                'link'	=> "transaksi-mutasi",
                'urutan'	=> 2,
                'parent'	=> 0,
                'grup'	=> "TRANSAKSI",
                'grup_urutan'	=> 2
            ],
            [
                'nama'	=> "Biaya Transport Orang Darat/Laut",
                'link'	=> "biaya-transport",
                'urutan'	=> 1,
                'parent'	=> 0,
                'grup'	=> "DASAR PERHITUNGAN",
                'grup_urutan'	=> 3
            ],
            [
                'nama'	=> "Biaya Muat Barang Darat/Laut",
                'link'	=> "biaya-muat",
                'urutan'	=> 2,
                'parent'	=> 0,
                'grup'	=> "DASAR PERHITUNGAN",
                'grup_urutan'	=> 3
            ],
            [
                'nama'	=> "Biaya Pengepakan Barang",
                'link'	=> "biaya-pengepakan",
                'urutan'	=> 3,
                'parent'	=> 0,
                'grup'	=> "DASAR PERHITUNGAN",
                'grup_urutan'	=> 3
            ],
            [
                'nama'	=> "Max Barang Kilogram Per Golongan",
                'link'	=> "barang-golongan",
                'urutan'	=> 4,
                'parent'	=> 0,
                'grup'	=> "DASAR PERHITUNGAN",
                'grup_urutan'	=> 3
            ],
            [
                'nama'	=> "Uang H",
                'link'	=> "uangh",
                'urutan'	=> 5,
                'parent'	=> 0,
                'grup'	=> "DASAR PERHITUNGAN",
                'grup_urutan'	=> 3
            ],
            [
                'nama'	=> "Transport",
                'link'	=> "transport",
                'urutan'	=> 1,
                'parent'	=> 0,
                'grup'	=> "TRANSPORTASI",
                'grup_urutan'	=> 4
            ],
            [
                'nama'	=> "Darat",
                'link'	=> "darat",
                'urutan'	=> 2,
                'parent'	=> 0,
                'grup'	=> "TRANSPORTASI",
                'grup_urutan'	=> 4
            ],
            [
                'nama'	=> "Laut",
                'link'	=> "laut",
                'urutan'	=> 3,
                'parent'	=> 0,
                'grup'	=> "TRANSPORTASI",
                'grup_urutan'	=> 4
            ],
            [
                'nama'	=> "SBU/M",
                'link'	=> "sbum",
                'urutan'	=> 4,
                'parent'	=> 0,
                'grup'	=> "TRANSPORTASI",
                'grup_urutan'	=> 4
            ],
            [
                'nama'	=> "Dep Hub",
                'link'	=> "dephub",
                'urutan'	=> 5,
                'parent'	=> 0,
                'grup'	=> "TRANSPORTASI",
                'grup_urutan'	=> 4
            ],
            [
                'nama'	=> "Provinsi",
                'link'	=> "provinsi",
                'urutan'	=> 1,
                'parent'	=> 0,
                'grup'	=> "LOKASI",
                'grup_urutan'	=> 5
            ],
            [
                'nama'	=> "Kota",
                'link'	=> "kota",
                'urutan'	=> 2,
                'parent'	=> 0,
                'grup'	=> "LOKASI",
                'grup_urutan'	=> 5
            ],
            [
                'nama'	=> "Rute",
                'link'	=> "rute",
                'urutan'	=> 3,
                'parent'	=> 0,
                'grup'	=> "LOKASI",
                'grup_urutan'	=> 5
            ],
            [
                'nama'	=> "Paraf",
                'link'	=> "paraf",
                'urutan'	=> 1,
                'parent'	=> 0,
                'grup'	=> "LAINNYA",
                'grup_urutan'	=> 6
            ],
            [
                'nama'	=> "Pejabat Pembuat Komitmen",
                'link'	=> "pejabat_komitmen",
                'urutan'	=> 2,
                'parent'	=> 0,
                'grup'	=> "LAINNYA",
                'grup_urutan'	=> 6
            ],
            [
                'nama'	=> "Master Kelompok Jabatan",
                'link'	=> "kelompok_jabatan",
                'urutan'	=> 3,
                'parent'	=> 0,
                'grup'	=> "LAINNYA",
                'grup_urutan'	=> 6
            ],
            [
                'nama'	=> "User",
                'link'	=> "user",
                'urutan'	=> 1,
                'parent'	=> 0,
                'grup'	=> "PENGGUNA",
                'grup_urutan'	=> 7
            ],
        ]);
    }
}
