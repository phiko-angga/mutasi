@extends('layout._template_transaksi_pdf',['title' => $title])
@section('content')

<table style="width:100%">
    <tbody>
        <tr>
            <td style="width:50%">
                <div style="width:80%;text-align:center">
                    <h5><b style="font-size:18px">MAHKAMAH AGUNG RI</b><br>DIREKTORAT JENDERAL<br>BADAN PERADILAN UMUM<br>JAKARTA</h5>
                </div>
            </td>
            <td style="width:50%">

                <table>
                    <tbody>
                        <tr>
                            <td style="width:80px;;font-weight:700">Lembar Ke <span style="float:right">:&nbsp;&nbsp;</span></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:80px;;font-weight:700">Kode No <span style="float:right">:&nbsp;&nbsp;</span></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:80px;font-weight:700">Nomor <span style="float:right">:&nbsp;&nbsp;</span></td>
                            <td> {{$data->nomor}}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr style="text-align:center;width:100%">
            <td colspan="2">
                <h5><strong>{{$title}}</strong></h5>
            </td>
        </tr>
    </tbody>
</table>

<div class="row">
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
                            <p>a. Lama perjalanan dinas</p>
                            <p>b. Tanggal berangkat</p>
                            <p>b. Tanggal harus kembali/tiba di tempat baru</p>
                        </td>
                        <td>
                            <p>{{$data->lama_perj_dinas}}</p>
                            <p>{{Carbon\Carbon::parse($data->tanggal_berangkat)->formatLocalized('%d %B %Y')}}</p>
                            <p>{{Carbon\Carbon::parse($data->tanggal_kembali)->formatLocalized('%d %B %Y')}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td colspan="2">
                            <table style="width:100%">
                                <tbody>
                                    <tr>
                                        <td>Pengikut : &nbsp;&nbsp;&nbsp; Nama</td>
                                        <td>Tanggal Lahir / Umur</td>
                                        <td>Keterangan</td>
                                    </tr>
                                    @isset($data->keluarga)
                                        @foreach($data->keluarga as $kel)
                                            <tr>
                                                <td>a. {{$kel->nama}}</td>
                                                <td>{{Carbon\Carbon::parse($kel->tanggal_lahir)->formatLocalized('%d %B %Y')}}</td>
                                                <td>{{$kel->keterangan}}</td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>
                            <p>Pembebanan Anggaran</p>
                            <p>a. Instansi</p>
                            <p>b. Mata Anggaran</p>
                        </td>
                        <td style="text-align:center">
                            <b>DIREKTORAT JENDERAL BADAN PERADILAN UMUM</b>
                        </td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>
                            Keterangan lain lain
                        </td>
                        <td>
                            {{$data->ket_lain2}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12" style="margin-top:20px">
        <table style="width:100%">
            <tbody>
                <tr>
                    <td style="width:60%">
                        
                    </td>
                    <td style="width:40%">

                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="width:80px;;font-weight:700">Dikeluarkan <span style="float:right">:&nbsp;&nbsp;</span></td>
                                    <td>Jakarta,</td>
                                </tr>
                                <tr>
                                    <td style="width:80px;;font-weight:700">Tanggal <span style="float:right">:&nbsp;&nbsp;</span></td>
                                    <td>{{Carbon\Carbon::parse(date('Y-m-d'))->formatLocalized('%d %B %Y')}}</td>
                                </tr>
                                <tr style="text-align:center">
                                    <td colspan="2">
                                        <h4>DIREKTORAT JENDERAL<br>BADAN PERADILAN UMUM</h4>
                                        <h4>Pejabat Pembuat Komitmen (PPK)</h4>
                                        <h4 style="margin-top:28px">{{$data->pejabat_komitmen_nama}}</h4>
                                        <h4>NIP. {{$data->pejabat_komitmen_nip}}</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

 <!-- RINCIAN BIAYA -->
<table style="width:100%">
    <tbody>
        <tr>
            <td style="width:50%">
                <div style="width:80%;text-align:center">
                    <h5><b style="font-size:18px">MAHKAMAH AGUNG RI</b><br>DIREKTORAT JENDERAL<br>BADAN PERADILAN UMUM<br>JAKARTA</h5>
                </div>
            </td>
            <td style="width:50%">

                <table>
                    <tbody>
                        <tr>
                            <td style="width:80px;;font-weight:700">Lampiran SPD  <span style="float:right">:&nbsp;&nbsp;</span></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:80px;;font-weight:700">Tanggal <span style="float:right">:&nbsp;&nbsp;</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr style="text-align:center;width:100%">
            <td colspan="2">
                <h5><strong>RINCIAN BIAYA PERJALANAN DINAS</strong></h5>
            </td>
        </tr>
    </tbody>
</table>

<div class="row">
    <div class="col-12">

        <div class="table-responsive">
            <table class="table table-bordered" border="1">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Rincian Biaya</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center">I</td>
                        <td>
                            <h4>TRANSPORT :</h4>
                            @isset($data->transport)
                                @foreach($data->transport as $tr)
                                    <p>{{$tr->transport_nama}} : {{$tr->kotaa_nama}} - {{$tr->kotat_nama}}</p>
                                    <p>{{$tr->orang}} x Rp. {{number_format($tr->biaya_perorang)}}</p>
                                @endforeach
                            @endisset
                        </td>
                        <td style="text-align:right">
                            @isset($data->transport)
                                @foreach($data->transport as $tr)
                                    <p>Rp. {{number_format($tr->jumlah_biaya)}}</p>
                                @endforeach
                            @endisset
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:center">II</td>
                        <td>
                            <h4>BARANG :</h4>
                            <p>Pengepakan / Penggudangan</p>
                                    <p>: {{$data->pengepakan_berat}} x Rp. {{number_format($data->pengepakan_tarif)}}</p>
                            @isset($data->muat)
                                @foreach($data->muat as $mu)
                                    <p>{{$mu->transport_nama}} : {{$mu->kotaa_nama}} - {{$mu->kotat_nama}}</p>
                                    <p>: {{$mu->berat}} x {{$mu->jarak}} Km x Rp. {{number_format($mu->tarif)}}</p>
                                @endforeach
                            @endisset
                        </td>
                        <td style="text-align:right">
                            <h4></h4>
                            <p></p>
                            <p>Rp. {{number_format($data->pengepakan_biaya)}}</p>
                            @isset($data->muat)
                                @foreach($data->muat as $mu)
                                    <p> </p>
                                    <p>Rp. {{number_format($mu->biaya)}}</p>
                                @endforeach
                            @endisset
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:center">III</td>
                        <td>
                            <h4>UANG HARIAN :</h4>
                            <p>...</p>
                            <p>: {{$data->uangh_jml_orang}} Orang x Rp. {{number_format($data->uangh_jml_tarif)}} x {{$data->uangh_jml_hari}} Hari</p>
                           
                        </td>
                        <td style="text-align:right">
                            <h4></h4>
                            <p></p>
                            <p>Rp. {{number_format($data->uangh_jml_biaya)}}</p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:center" colspan="2">
                            <h4>JUMLAH</h4>
                        </td>
                        <td style="text-align:right;font-weight:800">
                            <p>Rp. {{number_format($data->rampung_jumlah)}}</p>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            
            <div style="margin-top:18px;font-size:16px">
                <span style="width:140px">Terbilang</span>
                <span style="font-weight:800"> : {{$data->uangh_jml_terbilang}}</span>
            </div>
        </div>
    </div>
</div>


@endsection
