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
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control numeric" id="uangh_jml_uang" name="uangh_jml_uang" />
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control numeric" id="uangh_jml_terbilang" name="uangh_jml_terbilang" />
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-4">
                                        <div class="col-sm-12 text-center">
                                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Back</button>
                                            <button type="button" class="btn btn-primary" onclick="stepper.next()">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>