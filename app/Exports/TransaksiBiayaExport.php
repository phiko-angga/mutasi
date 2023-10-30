<?php

namespace App\Exports;

use App\Models\TransaksiBiaya;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiBiayaExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    private $row;
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        
        $data = [
            'No.',
            'Nama Pegawai',
            'NIP Pegawai',
            'Pangkat Gol. Ruang Gaji',
            'Status Kawin',
            'Jabatan / Instansi',
            'Nama Jabatan',
            'Kelompok Jabatan',
            'Total Biaya',
            'Tingkat Perjalanan Dinas',
            'Jumlah Ikut',
            'Maksud Perjalanan Dinas',
            'Alat Angkutan (jenis transportasi)',
            'Tempat Berangkat',
            'Provinsi Berangkat',
            'Tempat Tujuan',
            'Provinsi Tujuan',
            'Lama Perjalanan',
            'Tgl Berangkat',
            'Tgl Tiba',
            'Pejabat Berwenang Pemberi Perintah',
            'Pembebanan Biaya - Instansi',
            'Pembebanan Biaya - Mata Anggaran',
            'Tertanggal',
            'Nama PPK',
            'NIP PPK',
            'Keterangan lain - lain',
            'Tgl Dievaluasi',
            'Nama Evaluasi Data',
            'Tanggal dibuat',
            'Nama pembuat',
            'Tanggal diubah',
            'Nama pengubah',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            ++$this->row,
            $row->pegawai_diperintah,
            $row->nip,
            $row->pangkat.' - '.$row->golongan,
            $row->status_perkawinan,
            $row->jabatan_instansi,
            $row->jabatan_instansi,
            $row->kelompok_jabatan_nama,
            number_format($row->rampung_jumlah),
            $row->tingkat_perj_dinas,
            $row->jumlah_pengikut,
            substr($row->maksud_perj_dinas,0,49),
            $row->transport_nama,
            $row->kotaa_nama,
            $row->provinsia_nama,
            $row->kotat_nama,
            $row->provinsit_nama,
            $row->lama_perj_dinas,
            Carbon::parse($row->tanggal_berangkat)->formatLocalized('%d %B %Y'),
            Carbon::parse($row->tanggal_kembali)->formatLocalized('%d %B %Y'),
            $row->pejabat_komitmen_nama,
            $row->pembebanan_anggaran,
            $row->mata_anggaran,
            Carbon::parse($row->tanggal)->formatLocalized('%d %B %Y'),
            $row->pejabat_komitmen_nama2,
            $row->pejabat_komitmen_nip2,
            $row->ket_lain2,
            '',
            '',
            $row->created_at,
            $row->created_name,
            $row->updated_at,
            $row->updated_name,
        ];

        return $data;
    }
    
    public function collection()
    {
        $transaksi_biaya = new TransaksiBiaya();
        $data = $transaksi_biaya->get_data($this->request,true,['approved' => 0]);
        return $data;
        
    }
}
