<div class="row">
                    <!-- Basic Layout -->
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Lampiran SPPD Nomor</label>
                                            <div class="col-sm-8">
                                                <input readonly type="text" class="form-control" id="lampiran_sppd_no" value="{{old('lampiran_sppd_no',isset($biaya) ? $biaya->lampiran_sppd_no : '')}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nama">Tanggal</label>
                                            <div class="col-sm-8">
                                                <input readonly type="date" class="form-control" id="lampiran_tanggal" value="{{old('tanggal',isset($biaya) ? $biaya->tanggal : date('Y-m-d'))}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <h6><b>Biaya transport (AA,AK kurang atau sama 2 (dua) Thn 0.67%)</b></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive row-table">
                                            <table class="table" style="height:10rem;">
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

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7"></td>
                                                        <td>
                                                            <h6 id="trans_total_biaya"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="10" class="text-end">
                                                            <button title="Tambah transport" type="button" class="trans_add btn btn-sm rounded-pill btn-icon btn-primary">
                                                                <span class="tf-icons bx bx-plus"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div style="display:none" class="row mt-5 panel_transport_pembantu">
                                    <div class="col-md-12">
                                        <h6><b>Transport untuk pembantu jika ada (Khusus untuk golongan IV)</b></h6>
                                    </div>
                                </div>

                                <div style="display:none" class="row panel_transport_pembantu">
                                    <div class="col-sm-12">
                                        <div class="table-responsive row-table">
                                            <table class="table" style="height:10rem;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2" class="text-center">Nomor & Transport</th>
                                                        <th colspan="2" class="text-center">Keberangkatan & Tujuan</th>
                                                        <th colspan="3" class="text-center">Keterangan</th>
                                                    </tr>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Jenis Transport</th>
                                                        <th>Tempat berangkat</th>
                                                        <th>Tempat tujuan</th>
                                                        <th>Rincian Perkiraan</th>
                                                        <th>Jumlah biaya</th>
                                                        <th>Metode</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="item-transport-pembantu">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td>
                                                            <h6 id="trans_total_biaya_pembantu"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="text-end">
                                                            <button title="Tambah transport pembantu" type="button" class="trans_add_pembantu btn btn-sm rounded-pill btn-icon btn-primary">
                                                                <span class="tf-icons bx bx-plus"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row justify-content-end mt-4">
                                    <div class="col-sm-12 text-center">
                                        <button type="button" class="btn btn-primary" onclick="stepper.previous()">Back</button>
                                        <button type="button" class="btn btn-primary btn-stepper-next" data-step="1">Next</button>
                                        <a href="{{url('transaksi-biaya')}}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>