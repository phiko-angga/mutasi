@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th>Nama Pegawai</th>
                        <th>NIP Pegawai</th>
                        <th>Pangkat Gol. Ruang Gaji</th>
                        <th>Status Kawin</th>
                        <th>Jabatan / Instansi</th>
                        <th>Nama Jabatan</th>
                        <th>Kelompok Jabatan</th>
                        <th>Total Biaya</th>
                        <th>Tingkat Perjalanan Dinas</th>
                        <th>Jumlah Ikut</th>
                        <!-- <th>Maksud Perjalanan Dinas</th> -->
                        <!-- <th>Alat Angkutan (jenis transportasi)</th>
                        <th>Tempat Berangkat</th>
                        <th>Provinsi Berangkat</th>
                        <th>Tempat Tujuan</th>
                        <th>Provinsi Tujuan</th>
                        <th>Lama Perjalanan</th>
                        <th>Tgl Berangkat</th>
                        <th>Tgl Tiba</th>
                        <th>Pejabat Berwenang Pemberi Perintah</th>
                        <th>Pembebanan Biaya - Instansi</th>
                        <th>Pembebanan Biaya - Mata Anggaran</th>
                        <th>Tertanggal</th>
                        <th>Nama PPK</th>
                        <th>NIP PPK</th>
                        <th>Keterangan lain - lain</th>
                        <th>Tgl Dievaluasi</th>
                        <th>Nama Evaluasi Data</th> -->
                        <th>Tanggal dibuat</th>
                        <th>Nama pembuat</th>
                        <th>Tanggal diubah</th>
                        <th>Nama pengubah</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($data) !== 0)
                    @foreach($data as $key => $row)
                    <tr>
                        <td>{{ $data->firstItem() + $key}}</td>
                        <td>{{ $row->pegawai_diperintah }}</td>
                        <td>{{ $row->nip }}</td>
                        <td>{{ $row->pangkat.' - '.$row->golongan }}</td>
                        <td>{{ $row->status_perkawinan }}</td>
                        <td>{{ $row->jabatan_instansi }}</td>
                        <td>{{ $row->jabatan_instansi }}</td>
                        <td>{{ $row->kelompok_jabatan_nama }}</td>
                        <td>{{ number_format($row->rampung_jumlah) }}</td>
                        <td>{{ $row->tingkat_perj_dinas }}</td>
                        <td>{{ $row->jumlah_pengikut }}</td>
                        <!-- <td style="width:250px">{{ substr($row->maksud_perj_dinas,0,49) }} ...</td> -->
                        <!-- <td>{{ $row->transport_nama }}</td>
                        <td>{{ $row->kotaa_nama }}</td>
                        <td>{{ $row->provinsia_nama }}</td>
                        <td>{{ $row->kotat_nama }}</td>
                        <td>{{ $row->provinsit_nama }}</td>
                        <td>{{ $row->lama_perj_dinas }}</td>
                        <td>{{Carbon\Carbon::parse($row->tanggal_berangkat)->formatLocalized('%d %B %Y')}}</td>
                        <td>{{Carbon\Carbon::parse($row->tanggal_kembali)->formatLocalized('%d %B %Y')}}</td>
                        <td>{{ $row->pejabat_komitmen_nama }}</td>
                        <td>{{ $row->pembebanan_anggaran }}</td>
                        <td>{{ $row->mata_anggaran }}</td>
                        <td>{{Carbon\Carbon::parse($row->tanggal)->formatLocalized('%d %B %Y')}}</td>
                        <td>{{ $row->pejabat_komitmen_nama2 }}</td>
                        <td>{{ $row->pejabat_komitmen_nip2 }}</td>
                        <td>{{ $row->ket_lain2 }}</td>
                        <td></td>
                        <td></td> -->
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->created_name }}</td>
                        <td>{{ $row->updated_at }}</td>
                        <td>{{ $row->updated_name }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" align="center">
                            <h4 class="text-center">No Data Available</h4>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
