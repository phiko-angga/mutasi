@extends('layout._template_transaksi_pdf',['title' => $title])

@section('content')

<table id="master">
    <tbody>
        <tr style="width:100%">
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">MAHKAMAH AGUNG RI</h5></td> 
            <td style="font-weight:700" colspan="3">Lembar Ke <span style="float:right">:&nbsp;&nbsp;</span></td>
            <td>: </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">DIREKTORAT JENDERAL</h5></td> 
            <td style="font-weight:700" colspan="3">Kode No <span style="float:right">:&nbsp;&nbsp;</span></td>
            <td>: </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">BADAN PERADILAN UMUM</h5></td> 
            <td style="font-weight:700" colspan="3">Nomor <span style="float:right">:&nbsp;&nbsp;</span></td>
            <td>: {{$data->nomor}}</td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">JAKARTA</h5></td> 
            <td></td>
        </tr>
        <tr></tr>
        <tr>
            <td style="text-align:center;" colspan="15">
                <h5><b>SURAT PERJALANAN DINAS (SPD)</b></h5>
            </td>
        </tr>
        <tr></tr>
        
        <tr>
            <td>1</td>
            <td colspan="5">Pejabat Pembuat Komitmen</td>
            <td colspan="10">SEKRETARIAT DITJEN BADAN PERADILAN UMUM</td>
        </tr>
        <tr>
            <td>2</td>
            <td colspan="5">
                <p>Nama pegawai diperintahkan</P>
                <p>NIP</P>
            </td>
            <td colspan="10">
                <p>{{$data->pegawai_diperintah}}</P>
                <p>{{$data->nip}}</P>
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td colspan="5">
                <p>a. Pangkat dan Gol. Ruang Gaji (PP No. 6 Tahun 1997)</P>
                <p>b. Jabatan Instansi</P>
                <p>c. Tingkat Biaya Perjalanan Dinas</P>
            </td>
            <td colspan="10">
                <p>{{$data->pangkat.' - '.$data->golongan}}</P>
                <p>{{$data->jabatan_instansi}}</P>
                <p>{{$data->tingkat_perj_dinas}}</P>
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td colspan="5">Maksud Perjalanan Dinas</td>
            <td colspan="10">{{$data->maksud_perj_dinas}}</td>
        </tr>
        <tr>
            <td>5</td>
            <td colspan="5">Alat angkutan yang dipergunakan</td>
            <td colspan="10">{{$data->transport_nama}}</td>
        </tr>
        <tr>
            <td>6</td>
            <td colspan="5">
                <p>a. Tempat berangkat</P>
                <p>b. Tempat tujuan</P>
            </td>
            <td colspan="10">
                <p>{{$data->kotaa_nama}}</P>
                <p>{{$data->kotat_nama}}</P>
            </td>
        </tr>
        <tr>
            <td>7</td>
            <td colspan="5">
                <p>a. Lama perjalanan dinas</p>
                <p>b. Tanggal berangkat</p>
                <p>b. Tanggal harus kembali/tiba di tempat baru</p>
            </td>
            <td colspan="10">
                <p>{{$data->lama_perj_dinas}}</p>
                <p>{{Carbon\Carbon::parse($data->tanggal_berangkat)->formatLocalized('%d %B %Y')}}</p>
                <p>{{Carbon\Carbon::parse($data->tanggal_kembali)->formatLocalized('%d %B %Y')}}</p>
            </td>
        </tr>
        <tr></tr>
        <tr>
            <td>8</td>
            <td colspan="5">
                Pengikut : Nama
            </td>
            <td colspan="7" style="text-align:center">Tanggal Lahir / Umur</td>
            <td colspan="3" style="text-align:center">Keterangan</td>
        </tr>
        @isset($data->keluarga)
            @php
                $char = "a";
            @endphp
            @foreach($data->keluarga as $kel)
                <tr>
                    <td></td>
                    <td colspan="2">{{$char}}.</td>
                    <td colspan="3">{{$kel->nama}}</td>
                    <td colspan="7" style="text-align:center">{{Carbon\Carbon::parse($kel->tanggal_lahir)->formatLocalized('%d %B %Y')}}</td>
                    <td colspan="3" style="text-align:center">{{$kel->keterangan}}</td>
                </tr>
            @php
                ++$char;
            @endphp
            @endforeach
        @endisset
        <tr>
            <td>9</td>
            <td colspan="5">
                <p>Pembebanan Anggaran</p>
                <p>a. Instansi</p>
                <p>b. Mata Anggaran</p>
            </td>
            <td colspan="10" style="text-align:center">
                <b>DIREKTORAT JENDERAL BADAN PERADILAN UMUM</b>
            </td>
        </tr>
        <tr>
            <td>10</td>
            <td colspan="5">
                Keterangan lain lain
            </td>
            <td colspan="10">
                {{$data->ket_lain2}}
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="6"></td>
            <td colspan="10" style="text-align:center">
                <table>
                    <tbody>
                        <tr>
                            <td style="width:80px;font-weight:700">Dikeluarkan <span style="float:right">:&nbsp;&nbsp;</span></td>
                            <td>Jakarta,</td>
                        </tr>
                        <tr>
                            <td style="width:80px;;font-weight:700">Tanggal <span style="float:right">:&nbsp;&nbsp;</span></td>
                            <td>{{Carbon\Carbon::parse(date('Y-m-d'))->formatLocalized('%d %B %Y')}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                                <p style="margin-bottom:40px">DIREKTORAT JENDERAL<br>BADAN PERADILAN UMUM<br>Pejabat Pembuat Komitmen (PPK)</p>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                                <p>{{$data->pejabat_komitmen_nama}}<br>
                                NIP. {{$data->pejabat_komitmen_nip}}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>


@endsection
