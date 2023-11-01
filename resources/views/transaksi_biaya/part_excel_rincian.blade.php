@extends('layout._template_transaksi_pdf',['title' => $title])
@section('content')
<table>
    <tbody>
        <tr style="width:100%">
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">MAHKAMAH AGUNG RI</h5></td> 
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">DIREKTORAT JENDERAL</h5></td> 
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">BADAN PERADILAN UMUM</h5></td> 
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">JAKARTA</h5></td> 
        </tr>
        <tr></tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="14"><h5><b>{{$title}}</b></h5></td> 
        </tr>
        <tr></tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">Lampiran SPD Nomor</h5></td> 
            <td colspan="7">{{$data->nomor}}</td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">Tanggal</h5></td> 
            <td colspan="7">{{Carbon\Carbon::parse($data->tanggal)->formatLocalized('%d %B %Y')}}</td>
        </tr>

        <tr>
            <td>No.</td>
            <td colspan="9">Rincian Biaya</td>
            <td colspan="2">Jumlah</td>
            <td colspan="3">Keterangan</td>
        </tr>
        <tr>
            <td style="text-align:center">I</td>
            <td colspan="9">
                <h4>TRANSPORT :</h4>
                @isset($data->transport)
                    @foreach($data->transport as $tr)
                        <p>{{$tr->transport_nama}} : {{$tr->kotaa_nama}} - {{$tr->kotat_nama}}</p>
                        <p>{{$tr->orang}} x Rp. {{number_format($tr->biaya_perorang)}}</p>
                    @endforeach
                @endisset
            </td>
            <td colspan="2" style="text-align:right">
                @isset($data->transport)
                    @foreach($data->transport as $tr)
                        <p>Rp. {{number_format($tr->jumlah_biaya)}}</p>
                    @endforeach
                @endisset
            </td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td style="text-align:center">II</td>
            <td colspan="9">
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
            <td colspan="2" style="text-align:right">
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
            <td colspan="3"></td>
        </tr>
        <tr>
            <td style="text-align:center">III</td>
            <td colspan="9">
                <h4>UANG HARIAN :</h4>
                <p>{{$data->status_perkawinan}} di {{$data->kotat_nama}}, {{$data->provinsit_nama}}</p>
                <p>: {{$data->uangh_jml_orang}} Orang x Rp. {{number_format($data->uangh_jml_tarif)}} x {{$data->uangh_jml_hari}} Hari</p>
                
            </td>
            <td colspan="2" style="text-align:right">
                <h4></h4>
                <p></p>
                <p>Rp. {{number_format($data->uangh_jml_biaya)}}</p>
            </td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="9" style="text-align:center">
                <h4>JUMLAH</h4>
            </td>
            <td colspan="2" style="text-align:right;font-weight:800">
                <p>Rp. {{number_format($data->rampung_jumlah)}}</p>
            </td>
            <td colspan="3"></td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="3">Terbilang</td>
            <td colspan="13">: {{$data->uangh_jml_terbilang}}</td>
        </tr>
        
        <tr>
            <td colspan="5" style="text-align:left;width:50%">
                <p>Telah dibayar sejumlah</p>
                <p>Rp {{number_format($data->rampung_dibayar)}}</p>
            </td>
            <td colspan="6"></td>
            <td colspan="5" style="text-align:left">
                <p>Jakarta,</p>
                <p>Telah menerima jumlah uang sebesar</p>
                <p>Rp {{number_format($data->rampung_dibayar)}}</p>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align:center;width:50%">
                <p style="margin-bottom:40px">Bendaharawan</p>
            </td>
            <td colspan="6"></td>
            <td colspan="5" style="text-align:center">
                <p style="margin-bottom:40px">Yang menerima/dikuasakan</p>
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="7" style="text-align:center;width:50%">
                <p>{{$data->bendaharawan_nama}}<br>
                NIP. {{$data->bendaharawan_nip}}
                </p>
            </td>
            <td colspan="6"></td>
            <td colspan="5" style="text-align:center">
                <p>{{$data->kuasa_nama}}<br>
                NIP. {{$data->kuasa_nip}}
                </p>
            </td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="5" style="width:160px;;font-weight:700">Ditetapkan sejumlah <span style="float:right">:&nbsp;&nbsp;</span></td>
            <td colspan="3" style="text-align:right">Rp {{number_format($data->rampung_jumlah)}}</td>
        </tr>
        <tr>
            <td colspan="5" style="width:160px;;font-weight:700">Yang telah dibayar <span style="float:right">:&nbsp;&nbsp;</span></td>
            <td colspan="3" style="text-align:right">Rp {{number_format($data->rampung_dibayar)}}</td>
        </tr>
        <tr>
            <td colspan="5" style="width:160px;font-weight:700">Sisa kurang/lebih <span style="float:right">:&nbsp;&nbsp;</span></td>
            <td colspan="3" style="text-align:right">Rp {{number_format($data->rampung_jumlah - $data->rampung_dibayar)}}</td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="12" style="width:70%"></td>
            <td colspan="4" style="text-align:center;">
                <p style="margin-bottom:40px">DIREKTORAT JENDERAL<br>BADAN PERADILAN UMUM<br>Pejabat Pembuat Komitmen (PPK)</p>
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="12" style="width:70%"></td>
            <td colspan="4" style="text-align:center;">
                <p>{{$data->pejabat_komitmen_nama}}<br>
                NIP. {{$data->pejabat_komitmen_nip}}
                </p>
            </td>
        </tr>
    </tbody>
</table>


@endsection
