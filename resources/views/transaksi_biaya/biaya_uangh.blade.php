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
                                                <input type="text" class="form-control numeric" id="uangh_jml_orang" name="uangh_jml_orang" value="{{old('uangh_jml_orang',isset($biaya) ? $biaya->uangh_jml_orang : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah hari</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control numeric" id="uangh_jml_hari" name="uangh_jml_hari" value="{{old('uangh_jml_hari',isset($biaya) ? $biaya->uangh_jml_hari : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Tarif Rp. / hari</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control numeric" id="uangh_jml_tarif" name="uangh_jml_tarif" value="{{old('uangh_jml_tarif',isset($biaya) ? $biaya->uangh_jml_tarif : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah biaya</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control numeric" id="uangh_jml_biaya" name="uangh_jml_biaya" value="{{old('uangh_jml_biaya',isset($biaya) ? $biaya->uangh_jml_biaya : 0)}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Pembantu</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control numeric" id="uangh_jml_pembantu" name="uangh_jml_pembantu" value="{{old('uangh_jml_pembantu',isset($biaya) ? $biaya->uangh_jml_pembantu : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah hari</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control numeric" id="uangh_jml_hari_p" name="uangh_jml_hari_p" value="{{old('uangh_jml_hari_p',isset($biaya) ? $biaya->uangh_jml_hari_p : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Tarif Rp. / hari</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control numeric" id="uangh_jml_tarif_p" name="uangh_jml_tarif_p" value="{{old('uangh_jml_tarif_p',isset($biaya) ? $biaya->uangh_jml_tarif_p : 0)}}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Jumlah biaya</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control numeric" id="uangh_jml_biaya_p" name="uangh_jml_biaya_p" value="{{old('uangh_jml_biaya_p',isset($biaya) ? $biaya->uangh_jml_biaya_p : 0)}}" />
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
                                                <input type="text" class="form-control numeric" id="uangh_jml_uang" name="uangh_jml_uang"  value="{{old('uangh_jml_uang',isset($biaya) ? $biaya->uangh_jml_uang : 0)}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">terbilang</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control" id="uangh_jml_terbilang" name="uangh_jml_terbilang"  value="{{old('uangh_jml_terbilang',isset($biaya) ? $biaya->uangh_jml_terbilang : '')}}"/>
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
                                                <input type="text" class="form-control numeric" id="rampung_jumlah" name="rampung_jumlah"  value="{{old('rampung_jumlah',isset($biaya) ? $biaya->rampung_jumlah : 0)}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Yang telah dibayar</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control numeric" id="rampung_dibayar" name="rampung_dibayar"  value="{{old('rampung_dibayar',isset($biaya) ? $biaya->rampung_dibayar : 0)}}"/>
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
                                                <input type="date" class="form-control" id="rampung_tgl_pelunasan" name="rampung_tgl_pelunasan"  value="{{old('rampung_tgl_pelunasan',isset($biaya) ? $biaya->rampung_tgl_pelunasan : '')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Tahun Anggaran</label>
                                            <div class="col-sm-8">
                                                <select name="rampung_thn_anggaran" id="rampung_thn_anggaran" class="form-select"></select>
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
                                                <select name="rampung_bendaharawan_id" id="rampung_bendaharawan_id" class="form-select select2advance" data-select2-placeholder="Nama bendaharawan" data-select2-url="{{url('get-select/jenis-transport')}}"></select>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="row mt-4">
                                        <div class="col-sm-12 text-center">
                                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Back</button>
                                            <button type="button" class="btn btn-primary" onclick="stepper.next()">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>