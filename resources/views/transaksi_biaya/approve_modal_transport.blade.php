    
<div class="divider text-start"><div class="divider-text">Biaya transport (AA,AK kurang atau sama 2 (dua) Thn 0.67%)</div></div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive row-table">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">Nomor & Transport</th>
                        <th colspan="2" class="text-center">Keberangkatan & Tujuan</th>
                        <th colspan="5" class="text-center">Jarak & Biaya</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>manual</th>
                        <th style="width:260px">Jenis Transport</th>
                        <th style="width:260px">Tempat berangkat</th>
                        <th style="width:260px">Tempat tujuan</th>
                        <th>Orang</th>
                        <th>Biaya @orang</th>
                        <th>Jumlah biaya</th>
                        <th style="width:300px">Metode</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="item-transport">
                @isset($biaya->transport)
                    @foreach($biaya->transport as $key => $k)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$k->manual == 1 ? 'Iya' : 'Tidak'}}</td>
                        <td>{{$k->transport_nama}}</td>
                        <td>{{$k->kotaa_nama.' - '.$k->provinsia_nama}}</td>
                        <td>{{$k->kotaa_nama.' - '.$k->provinsit_nama}}</td>
                        <td>{{$k->orang}}</td>
                        <td>{{number_format($k->biaya_perorang)}}</td>
                        <td>{{number_format($k->jumlah_biaya)}}</td>
                        <td>{{$k->metode}}</td>
                    </tr>
                    @endforeach
                @endisset
                </tbody>
            </table>
        </div>

    </div>
</div>


<div class="divider text-start"><div class="divider-text">Transport untuk pembantu jika ada (Khusus untuk golongan IV)</div></div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive row-table">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">Nomor & Transport</th>
                        <th colspan="2" class="text-center">Keberangkatan & Tujuan</th>
                        <th colspan="2" class="text-center">Keterangan</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Jenis Transport</th>
                        <th>Tempat berangkat</th>
                        <th>Tempat tujuan</th>
                        <th>Rincian Perkiraan</th>
                        <th>Jumlah biaya</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody id="item-transport">
                @isset($biaya->transport_pembantu)
                    @foreach($biaya->transport_pembantu as $key => $k)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$k->transport_nama}}</td>
                        <td>{{$k->kotaa_nama.' - '.$k->provinsia_nama}}</td>
                        <td>{{$k->kotaa_nama.' - '.$k->provinsit_nama}}</td>
                        <td>{{$k->rinci_perkiraan}}</td>
                        <td>{{number_format($k->jumlah_biaya)}}</td>
                        <td>{{$k->metode}}</td>
                    </tr>
                    @endforeach
                @endisset
                </tbody>
            </table>

        </div>
    </div>
</div>