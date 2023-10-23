@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-6">
    </div>
    <div class="col-6">
        <p class="d-flex flex-row mb-0">
            <strong style="width:80px">Lembar Ke</strong> 
            <span>: ...</span>
        </p>
        <p class="d-flex flex-row mb-0">
            <strong style="width:80px">Kode No</strong> 
            <span>: ...</span>
        </p>
        <p class="d-flex flex-row mb-0">
            <strong style="width:80px">Nomor</strong> 
            <span>: ...</span>
        </p>
    </div>
    <div class="col-12">

        <div class="table-responsive">
            <table class="table table-bordered" border="1">
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Pejabat Pembuat Komitmen</td>
                        <td class="fw-bold">SEKRETARIAT DITJEN BADAN PERADILAN UMUM</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <P>Nama pegawai diperintahkan</P>
                            <P>NIP</P>
                        </td>
                        <td>
                            <P>{{$data->pegawai_diperintah}}</P>
                            <P>{{$data->nip}}</P>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <P>a. Pangkat dan Gol. Ruang Gaji (PP No. 6 Tahun 1997)</P>
                            <P>b. Jabatan Instansi</P>
                            <P>c. Tingkat Biaya Perjalanan Dinas</P>
                        </td>
                        <td>
                            <P>{{$data->pangkat.' - '.$data->golongan}}</P>
                            <P>{{$data->jabatan_instansi}}</P>
                            <P>{{$data->tingkat_perj_dinas}}</P>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Maksud Perjalanan Dinas</td>
                        <td>{{$data->maksud_perj_dinas}}</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Alat angkutan yang dipergunakan</td>
                        <td>{{$data->transport_nama}}</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>
                            <P>a. Tempat berangkat</P>
                            <P>b. Tempat tujuan</P>
                        </td>
                        <td>
                            <P>{{$data->kotaa_nama}}</P>
                            <P>{{$data->kotat_nama}}</P>
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>
                            <P>a. Lama perjalanan dinas</P>
                            <P>b. Tanggal berangkat</P>
                            <P>b. Tanggal harus kembali/tiba di tempat baru</P>
                        </td>
                        <td>
                            <P>{{$data->lama_perj_dinas}}</P>
                            <P>{{Carbon\Carbon::parse($data->tanggal_berangkat)->formatLocalized('%d %B %Y')}}</P>
                            <P>{{Carbon\Carbon::parse($data->tanggal_kembali)->formatLocalized('%d %B %Y')}}</P>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
