<div class="row">
                    <!-- Basic Layout -->
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6><b>Uang Harian</b></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah orang</label>
                                            <div class="col-sm-8">
                                                <input readonly type="number" class="form-control" onchange="biayaCalculate('orang')" id="uangh_jml_orang" name="uangh_jml_orang" value="{{old('uangh_jml_orang',isset($biaya) ? $biaya->uangh_jml_orang : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah hari</label>
                                            <div class="col-sm-8">
                                                <input readonly type="number" class="form-control" onchange="biayaCalculate('orang')" id="uangh_jml_hari" name="uangh_jml_hari" value="{{old('uangh_jml_hari',isset($biaya) ? $biaya->uangh_jml_hari : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Tarif Rp. / hari</label>
                                            <div class="col-sm-8">
                                                <input required type="text" class="form-control numeric" onchange="biayaCalculate('orang')" id="uangh_jml_tarif" name="uangh_jml_tarif" value="{{old('uangh_jml_tarif',isset($biaya) ? $biaya->uangh_jml_tarif : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah biaya</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control numeric" id="uangh_jml_biaya" name="uangh_jml_biaya" value="{{old('uangh_jml_biaya',isset($biaya) ? $biaya->uangh_jml_biaya : 0)}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Pembantu</label>
                                            <div class="col-sm-8">
                                                <input readonly type="number" class="form-control" onchange="biayaCalculate('pembantu')" id="uangh_jml_pembantu" name="uangh_jml_pembantu" value="{{old('uangh_jml_pembantu',isset($biaya) ? $biaya->uangh_jml_pembantu : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah hari</label>
                                            <div class="col-sm-8">
                                                <input readonly type="number" class="form-control" onchange="biayaCalculate('pembantu')" id="uangh_jml_hari_p" name="uangh_jml_hari_p" value="{{old('uangh_jml_hari_p',isset($biaya) ? $biaya->uangh_jml_hari_p : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Tarif Rp. / hari</label>
                                            <div class="col-sm-8">
                                                <input required type="text" class="form-control numeric" onchange="biayaCalculate('pembantu')" id="uangh_jml_tarif_p" name="uangh_jml_tarif_p" value="{{old('uangh_jml_tarif_p',isset($biaya) ? $biaya->uangh_jml_tarif_p : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah biaya</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control numeric" id="uangh_jml_biaya_p" name="uangh_jml_biaya_p" value="{{old('uangh_jml_biaya_p',isset($biaya) ? $biaya->uangh_jml_biaya_p : 0)}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <h6><b>Total biaya mutasi secara keseluruhan</b></h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah uang</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control numeric" id="uangh_jml_uang" name="uangh_jml_uang"  value="{{old('uangh_jml_uang',isset($biaya) ? $biaya->uangh_jml_uang : 0)}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Terbilang</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control" id="uangh_jml_terbilang" name="uangh_jml_terbilang"  value="{{old('uangh_jml_terbilang',isset($biaya) ? $biaya->uangh_jml_terbilang : '-')}}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <h6><b>Perhitungan SPD Rampung</b></h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Ditetapkan sejumlah</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control numeric" id="rampung_jumlah" name="rampung_jumlah"  value="{{old('rampung_jumlah',isset($biaya) ? $biaya->rampung_jumlah : 0)}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Yang telah dibayar</label>
                                            <div class="col-sm-8">
                                                <input required type="text" class="form-control numeric" id="rampung_dibayar" name="rampung_dibayar"  value="{{old('rampung_dibayar',isset($biaya) ? $biaya->rampung_dibayar : 0)}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Sisa kurang  / lebih</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control" id="rampung_sisa" name="rampung_sisa"  value="{{old('rampung_sisa',isset($biaya) ? $biaya->rampung_sisa : 0)}}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <h6><b>Kwitansi</b></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Beban MAK</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control numeric" id="rampung_beban_mak" name="rampung_beban_mak"  value="{{old('rampung_beban_mak',isset($biaya) ? $biaya->rampung_beban_mak : 0)}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Bukti Kas No.</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="rampung_buktikas" name="rampung_buktikas"  value="{{old('rampung_buktikas',isset($biaya) ? $biaya->rampung_buktikas : '')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Tanggal Pelunasan</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="rampung_tgl_pelunasan" name="rampung_tgl_pelunasan"  value="{{old('rampung_tgl_pelunasan',isset($biaya) ? $biaya->rampung_tgl_pelunasan : date('Y-m-d'))}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Tahun Anggaran</label>
                                            <div class="col-sm-8">
                                                <select name="rampung_thn_anggaran" id="rampung_thn_anggaran" class="form-select">
                                                    <option {{isset($biaya) ? ($biaya->rampung_thn_anggaran == 2021 ? 'selected' : '') : ''}} value="2021">2021</option>
                                                    <option {{isset($biaya) ? ($biaya->rampung_thn_anggaran == 2022 ? 'selected' : '') : ''}} value="2022">2022</option>
                                                    <option {{isset($biaya) ? ($biaya->rampung_thn_anggaran == 2023 ? 'selected' : '') : 'selected'}} value="2023">2023</option>
                                                    <option {{isset($biaya) ? ($biaya->rampung_thn_anggaran == 2024 ? 'selected' : '') : ''}} value="2024">2024</option>
                                                    <option {{isset($biaya) ? ($biaya->rampung_thn_anggaran == 2025 ? 'selected' : '') : ''}} value="2025">2025</option>
                                                    <option {{isset($biaya) ? ($biaya->rampung_thn_anggaran == 2026 ? 'selected' : '') : ''}} value="2026">2026</option>
                                                    <option {{isset($biaya) ? ($biaya->rampung_thn_anggaran == 2027 ? 'selected' : '') : ''}} value="2027">2027</option>
                                                    <option {{isset($biaya) ? ($biaya->rampung_thn_anggaran == 2028 ? 'selected' : '') : ''}} value="2028">2028</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <h6><b>Pejabat Penandatangan</b></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Nama Bendaharawan</label>
                                            <div class="col-sm-8">
                                                <select style="width:100%" name="rampung_bendaharawan_id" id="rampung_bendaharawan_id" class="form-select select2advance" data-select2-placeholder="Nama bendaharawan" data-select2-url="{{url('get-select/paraf?kelompok=Bendaharawan')}}">
                                                    
                                                    @if(isset($biaya))
                                                        <option value="{{$biaya->rampung_bendaharawan_id}}" selected="selected">{{$biaya->bendaharawan_nama}}</option>
                                                    @else($bendaharawan)
                                                        <option value="{{$bendaharawan->id}}" selected="selected">{{$bendaharawan->nama}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">NIP Bendaharawan</label>
                                            <div class="col-sm-8">
                                                <input readonly type="text" value="{{isset($biaya) ? $biaya->bendaharawan_nip : $bendaharawan->nip }}" name="rampung_bendaharawan_nip" id="rampung_bendaharawan_nip" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">
                                                <div class="form-check">
                                                    <input class="form-check-input cb_kuasa" id="cb_kuasa" name="trans_manual[]" type="checkbox" value="1">
                                                    <label class="form-check-label" for="cb_kuasa"> Dikuasakan (jika tidak, nama pegawai yang bersangkutan)</label>
                                                </div>
                                            </label>
                                            <div class="col-sm-8">
                                                <select style="width:100%" name="rampung_kuasa" id="rampung_kuasa_select" class="form-select select2advance" data-select2-placeholder="Penerima" data-select2-url="{{url('get-select/paraf?kelompok=Yang menerima/dikuasakan')}}">
                                                
                                                    @if(isset($biaya))
                                                        <option value="{{$biaya->rampung_kuasa}}" selected="selected">{{$biaya->rampung_kuasa_nama}}</option>
                                                    @else($penerima)  
                                                        <option value="{{$penerima->id}}" selected="selected">{{$penerima->nama}}</option>
                                                    @endif
                                                </select>
                                                <input style="display:none" readonly type="text" name="rampung_kuasa_nama" id="rampung_kuasa_nama" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">NIP yang menerima/dikuasakan</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly name="rampung_kuasa_nip" id="rampung_kuasa_nip" value="{{isset($biaya) ? ($biaya->nip == null ? $biaya->kuasa_nip : $biaya->nip) : $penerima->nip }}" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Pejabat pembuat komitmen (PPK)</label>
                                            <div class="col-sm-8">
                                                <select style="width:100%" name="rampung_ppk_id" id="rampung_ppk_id" class="form-select select2advance" data-select2-placeholder="Pejabat pembuat komitmen" data-select2-url="{{url('get-select/ppk')}}">
                                                    @if(isset($biaya))
                                                        <option value="{{$biaya->rampung_ppk_id}}" selected="selected">{{$biaya->pejabat_komitmen_nama3}}</option>
                                                    @else($ppk) 
                                                        <option value="{{$ppk->id}}" selected="selected">{{$ppk->nama}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">NIP pejabat pembuat komitmen</label>
                                            <div class="col-sm-8">
                                                <input readonly type="text" name="rampung_ppk_nip" id="rampung_ppk_nip" value="{{isset($biaya) ? $biaya->pejabat_komitmen_nip3 : $ppk->nip }}" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Nama kuasa pengguna anggaran/pengguna barang</label>
                                            <div class="col-sm-8">
                                                <select style="width:100%" name="rampung_anggaran_id" id="rampung_anggaran_id" class="form-select select2advance" data-select2-placeholder="Nama kuasa pengguna anggaran/pengguna barang" data-select2-url="{{url('get-select/paraf?kelompok=Kuasa Pengguna Anggaran')}}">
                                                    @if(isset($biaya))
                                                        <option value="{{$biaya->rampung_anggaran_id}}" selected="selected">{{$biaya->pejabat_komitmen_nama4}}</option>
                                                    @else($kuasaanggaran) 
                                                        <option value="{{$kuasaanggaran->id}}" selected="selected">{{$kuasaanggaran->nama}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">NIP kuasa pengguna anggaran/pengguna barang</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly name="rampung_anggaran_nip" id="rampung_anggaran_nip" value="{{isset($biaya) ? $biaya->pejabat_komitmen_nip4 : $kuasaanggaran->nip }}" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 mt-4">
                                        <h6><b>Keterangan rincian perjalanan dinas</b></h6>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="rampung_rincian" id="rampung_rincian" cols="30" rows="4" class="form-control">{{old('rampung_rincian',isset($biaya) ? $biaya->rampung_rincian : '')}}</textarea>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-12 text-center">
                                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Back</button>
                                            <button type="submit" class="btn btn-primary btn-stepper-next" data-step="3">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>