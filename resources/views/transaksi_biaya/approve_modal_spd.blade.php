<div class="divider text-start"><div class="divider-text">#1</div></div>
<div class="row">
    <div class="col-md-12">
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Tanggal dikeluarkan</label>
            <div class="col-sm-8">
                {{Carbon\Carbon::parse($biaya->tanggal)->formatLocalized('%d %B %Y')}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">NAMA PEGAWAI YANG DIPERINTAHKAN</label>
            <div class="col-sm-8">
                {{$biaya->pegawai_diperintah}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Nomor</label>
            <div class="col-sm-8">
                {{$biaya->nomor}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">NIP</label>
            <div class="col-sm-8">
                {{$biaya->nip}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">PEJABAT PEMBUAT KOMITMEN</label>
            <div class="col-sm-8">
                {{$biaya->pejabat_komitmen_nama}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">PANGKAT DAN GOL. RUANG GAJI</label>
            <div class="col-sm-8">
                {{$biaya->pangkat.' - '.$biaya->golongan}}
            </div>
        </div>
    </div>
</div>

<div class="divider text-start"><div class="divider-text">#2</div></div>
<div class="row">
    <div class="col-md-12">
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Tingkat Perj. dinas</label>
            <div class="col-sm-8">
                {{$biaya->tingkat_perj_dinas}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Jenis Transportasi</label>
            <div class="col-sm-8">
                {{$biaya->transport_nama}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Tempat Berangkat</label>
            <div class="col-sm-8">
                {{$biaya->kotaa_nama.', '.$biaya->provinsia_nama}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Tempat tujuan</label>
            <div class="col-sm-8">
                {{$biaya->kotat_nama.', '.$biaya->provinsit_nama}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Ket. Keberangkatan</label>
            <div class="col-sm-8">
                {{$biaya->ket_keberangkatan}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Ket. ditujuan</label>
            <div class="col-sm-8">
                {{$biaya->ket_tujuan}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Tanggal Keberangkatan</label>
            <div class="col-sm-8">
                {{Carbon\Carbon::parse($biaya->tanggal_berangkat)->formatLocalized('%d %B %Y')}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Tanggal Harus kembali</label>
            <div class="col-sm-8">
                {{Carbon\Carbon::parse($biaya->tanggal_kembali)->formatLocalized('%d %B %Y')}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Lama perjalanan dinas</label>
            <div class="col-sm-8">
            {{$biaya->lama_perj_dinas}}
            </div>
        </div>
    </div>
</div>

<div class="divider text-start"><div class="divider-text">#3</div></div>
<div class="row">
    <div class="col-md-12">
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Status Perkawinan</label>
            <div class="col-sm-8">
                {{$biaya->status_perkawinan}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Maksud perjalanan dinas</label>
            <div class="col-sm-8">
                {{$biaya->maksud_perj_dinas}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Jumlah pengikut</label>
            <div class="col-sm-8">
                {{$biaya->jumlah_pengikut}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Pembantu ikut</label>
            <div class="col-sm-8">
                {{$biaya->pembantu_ikut == 1 ? 'Ya, ikut serta' : 'Tidak ada/Tidak ikut'}}
            </div>
        </div>

        <div class="row mb-1">
            <label class="col-sm-12 col-form-label" for="nama">Daftar keluarga yang ikut</label>
            <div class="col-sm-12">
                <div class="table-responsive row-table">
                    <table class="table" style="height:10rem;">
                    <thead>
                        <tr>
                        <th>Kena Biaya</th>
                        <th colspan="9" class="text-center">Daftar Nama Anggota Keluarga Yang Ikut Serta</th>
                        </tr>
                        <tr>
                        <th>Perj. Dinas</th>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Thn/Tgl. Lahir</th>
                        <th>Umur</th>
                        <th>Keterangan</th>
                        <th>Tanggal dibuat</th>
                        <th>Nama pembuat</th>
                        <th>Tanggal diubah</th>
                        <th>Nama pengubah</th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody id="item-keluarga">
                        @isset($biaya->keluarga)
                        @foreach($biaya->keluarga as $key => $k)
                            <tr>
                            <td>{{$k->biaya_perj_dinas == 1 ? 'Iya' : 'Tidak'}}</td>
                            <td>{{$key+1}}</td>
                            <td>{{$k->nama}}</td>
                            <td>{{Carbon\Carbon::parse($k->tanggal_lahir)->formatLocalized('%d %B %Y')}}</td>
                            <td>{{$k->umur}}</td>
                            <td>{{$k->keterangan}}</td>
                            <td>{{Carbon\Carbon::parse($k->created_at)->formatLocalized('%d %B %Y')}}</td>
                            <td>{{$k->created_name}}</td>
                            <td>{{Carbon\Carbon::parse($k->updated_at)->formatLocalized('%d %B %Y')}}</td>
                            <td>{{$k->updated_name}}</td>
                            </tr>
                        @endforeach
                        @endisset
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div class="divider text-start"><div class="divider-text">#4</div></div>
<div class="row">
    <div class="col-md-12">

        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Pembebanan Anggaran / Instansi</label>
            <div class="col-sm-8">
                {{$biaya->pembebanan_anggaran}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Mata Anggaran</label>
            <div class="col-sm-8">
                {{$biaya->mata_anggaran}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Keterangan lain - lain</label>
            <div class="col-sm-8">
                {{$biaya->ket_lain2}}
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-4 col-form-label" for="nama">Nama pejabat pembuat komitmen (PPK)</label>
            <div class="col-sm-8">
                {{$biaya->pejabat_komitmen_nama2.' - '.$biaya->pejabat_komitmen_nip2}}
            </div>
        </div>
    </div>
</div>