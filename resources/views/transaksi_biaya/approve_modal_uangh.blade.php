            
<div class="divider text-start"><div class="divider-text">Uang Harian</div></div>
<div class="row">
  <div class="col-md-12">

    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Jumlah orang</label>
      <div class="col-sm-8">
          {{$biaya->uangh_jml_orang}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Jumlah hari</label>
      <div class="col-sm-8">
          {{$biaya->uangh_jml_hari}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Tarif Rp. / hari</label>
      <div class="col-sm-8">
          {{number_format($biaya->uangh_jml_tarif)}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Jumlah biaya</label>
      <div class="col-sm-8">
          {{number_format($biaya->uangh_jml_biaya)}}
      </div>
    </div>

  </div>
</div>

<div class="divider text-start"><div class="divider-text">Pembantu</div></div>
<div class="row">
  <div class="col-md-12">

    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Jumlah orang</label>
      <div class="col-sm-8">
          {{$biaya->uangh_jml_pembantu}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Jumlah hari</label>
      <div class="col-sm-8">
          {{$biaya->uangh_jml_hari_p}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Tarif Rp. / hari</label>
      <div class="col-sm-8">
          {{number_format($biaya->uangh_jml_tarif_p)}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Jumlah biaya</label>
      <div class="col-sm-8">
          {{number_format($biaya->uangh_jml_biaya_p)}}
      </div>
    </div>
  </div>
</div>

<div class="divider text-start"><div class="divider-text">Total biaya mutasi secara keseluruhan</div></div>
<div class="row">
  <div class="col-md-12">

    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Jumlah uang</label>
      <div class="col-sm-8">
          {{number_format($biaya->uangh_jml_uang)}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Terbilang</label>
      <div class="col-sm-8">
          {{$biaya->uangh_jml_terbilang}}
      </div>
    </div>
  </div>
</div>

<div class="divider text-start"><div class="divider-text">Perhitungan SPD Rampung</div></div>
<div class="row">
  <div class="col-md-12">

    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Ditetapkan sejumlah</label>
      <div class="col-sm-8">
          {{number_format($biaya->rampung_jumlah)}}
      </div>
    </div>
    <div style="display:none" class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Yang telah dibayar</label>
      <div class="col-sm-8">
          {{number_format($biaya->rampung_dibayar)}}
      </div>
    </div>
    <div style="display:none" class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Sisa kurang  / lebih</label>
      <div class="col-sm-8">
          {{number_format($biaya->rampung_sisa)}}
      </div>
    </div>
  </div>
</div>

<div class="divider text-start"><div class="divider-text">Kwitansi</div></div>
<div class="row">
  <div class="col-md-12">

    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Beban MAK</label>
      <div class="col-sm-8">
          {{number_format($biaya->rampung_beban_mak)}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Bukti Kas No.</label>
      <div class="col-sm-8">
          {{$biaya->rampung_buktikas}}
      </div>
    </div>
    <div style="display:none" class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Tanggal Pelunasan</label>
      <div class="col-sm-8">
        {{Carbon\Carbon::parse($biaya->rampung_tgl_pelunasan)->formatLocalized('%d %B %Y')}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Tahun Anggaran</label>
      <div class="col-sm-8">
          {{$biaya->rampung_thn_anggaran}}
      </div>
    </div>
  </div>
</div>

<div class="divider text-start"><div class="divider-text">Pejabat Penandatangan</div></div>
<div class="row">
  <div class="col-md-12">

    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Nama Bendaharawan</label>
      <div class="col-sm-8">
          {{$biaya->bendaharawan_nama.' - '.$biaya->bendaharawan_nip}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Dikuasakan (jika tidak, nama pegawai yang bersangkutan)</label>
      <div class="col-sm-8">
          {{$biaya->kuasa_nama.' - '.$biaya->kuasa_nip}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Pejabat pembuat komitmen (PPK)</label>
      <div class="col-sm-8">
          {{$biaya->pejabat_komitmen_nama3.' - '.$biaya->pejabat_komitmen_nip3}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Nama kuasa pengguna anggaran/pengguna barang</label>
      <div class="col-sm-8">
          {{$biaya->pejabat_komitmen_nama4.' - '.$biaya->pejabat_komitmen_nip4}}
      </div>
    </div>
    <div class="row mb-1">
      <label class="col-sm-4 col-form-label" for="nama">Keterangan rincian perjalanan dinas</label>
      <div class="col-sm-8">
          {{$biaya->rampung_rincian}}
      </div>
    </div>
  </div>
</div>