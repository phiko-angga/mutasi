            
<div class="divider text-start"><div class="divider-text">Biaya pengepakan / penggudangan</div></div>
<div class="row">
    <div class="col-md-12">

        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Transportasi</label>
            <div class="col-sm-8">
                {{$biaya->pengepakan_transport_nama}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Berat Kg</label>
            <div class="col-sm-8">
                {{$biaya->pengepakan_berat}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Tarif Rp. / Kg</label>
            <div class="col-sm-8">
                {{number_format($biaya->pengepakan_tarif)}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Jumlah biaya</label>
            <div class="col-sm-8">
                {{number_format($biaya->pengepakan_biaya)}}
            </div>
        </div>

    </div>
</div>

<div class="divider text-start"><div class="divider-text">Biaya muat / pengiriman barang</div></div>
<div class="row">
    <div class="col-md-12">

        <div class="table-responsive row-table">
            <table class="table" style="height:10rem;">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">Nomor & Transport</th>
                        <th colspan="2" class="text-center">Keberangkatan & Tujuan</th>
                        <th colspan="4" class="text-center">Jarak & Biaya</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>manual</th>
                        <th>Jenis Transport</th>
                        <th>Tempat berangkat</th>
                        <th>Tempat tujuan</th>
                        <th>Berat</th>
                        <th>Jarak km/mil</th>
                        <th>Jumlah biaya</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody id="item-muatbarang">
                @isset($biaya->keluarga)
                        @foreach($biaya->muat as $key => $k)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$k->manual == 1 ? 'Iya' : 'Tidak'}}</td>
                                <td>{{$k->transport_nama}}</td>
                                <td>{{$k->kotaa_nama.' - '.$k->provinsia_nama}}</td>
                                <td>{{$k->kotaa_nama.' - '.$k->provinsit_nama}}</td>
                                <td>{{$k->berat}}</td>
                                <td>{{$k->jarak}}</td>
                                <td>{{number_format($k->biaya)}}</td>
                                <td>{{$k->metode}}</td>
                            </tr>
                        @endforeach
                        @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>