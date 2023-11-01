@extends('layout._template_transaksi_pdf',['title' => $title])
@section('content')

<table>
    <tbody>
    <tr style="width:100%">
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">MAHKAMAH AGUNG RI</h5></td> 
            <td style="font-weight:700" colspan="3">Beban MAK</td>
            <td>: {{$data->rampung_beban_mak}}</td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">DIREKTORAT JENDERAL</h5></td> 
            <td style="font-weight:700" colspan="3">Bukti Kas No.</td>
            <td>: {{$data->rampung_buktikas}}</td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">BADAN PERADILAN UMUM</h5></td> 
            <td style="font-weight:700" colspan="3">Tahun Anggaran</td>
            <td>: {{$data->nomor}}</td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:center;width:340px" colspan="3"><h5 style="font-size:18px;width:340px">JAKARTA</h5></td> 
            <td>: {{$data->rampung_thn_anggaran}}</td>
        </tr>
        
        <tr style="text-align:center">
            <td colspan="9">
                <h5><strong>KUITANSI</strong></h5>
                
            </td>
        </tr>

        <tr>
            <td colspan="3" style="font-weight:700">Sudah Terima Dari</td>
            <td>:</td>
            <td colspan="10">DIREKTORAT JENDERAL BADAN PERADILAN UMUM</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight:700">Uang Sebesar</td>
            <td>:</td>
            <td colspan="10">Rp {{number_format($data->rampung_jumlah)}}</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight:700">Untuk Pembayaran</td>
            <td>:</td>
            <td colspan="10">Biaya Perjalanan Dinas  An. {{$data->kuasa_nama}}</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight:700">Berdasarkan SPD Nomor</td>
            <td>:</td>
            <td colspan="10">{{$data->nomor}}</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight:700">Tanggal</td>
            <td>:</td>
            <td colspan="10">{{Carbon\Carbon::parse($data->tanggal_berangkat)->formatLocalized('%d %B %Y')}}</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight:700">Untuk Perjalanan Dinas dari</td>
            <td>:</td>
            <td colspan="10">{{$data->kotaa_nama}} ke {{$data->kotat_nama}}</td>
        </tr>
        <tr>
            <td colspan="2"><h4> Terbilang :</h4></td>
            <td colspan="12"><h4><b>{{$data->uangh_jml_terbilang}}</b></h4></td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="5" style="text-align:center;width:33%">
                <p style="margin-bottom:40px">Mengetahui/Menyetujui<br>Kuasa Pengguna Anggaran/<br>Pengguna Barang Th. {{$data->rampung_thn_anggaran}}</p>
            </td>
            <td colspan="4" style="text-align:center;width:33%">
                <p style="margin-bottom:40px">Bendaharawan<br><br></p>
            </td>
            <td colspan="5" style="text-align:center;width:33%">
                <p style="margin-bottom:40px">Yang menerima/dikuasakan<br><br></p>
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="5" style="text-align:center;width:33%">
                <p>{{$data->pejabat_komitmen_nama4}}<br>
                NIP. {{$data->pejabat_komitmen_nip4}}
                </p>
            </td>
            <td colspan="4" style="text-align:center;width:33%">
                <p>{{$data->bendaharawan_nama}}<br>
                NIP. {{$data->bendaharawan_nip}}
                </p>
            </td>
            <td colspan="5" style="text-align:center;width:33%">
                <p>{{$data->kuasa_nama}}<br>
                NIP. {{$data->kuasa_nip}}
                </p>
            </td>
        </tr>
    </tbody>
</table>


@endsection
