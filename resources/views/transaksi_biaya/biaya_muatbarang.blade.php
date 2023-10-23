<div class="row">
    <!-- Basic Layout -->
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
            <div class="col-md-12">
                    <h6><b>Biaya pengepakan / penggudangan</b></h6>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="nama">Transportasi</label>
                            <div class="col-sm-8">
                                <select name="pengepakan_transport_id" id="pengepakan_transport_id" class="form-select select2advance" data-select2-placeholder="Jenis transport" data-select2-url="{{url('get-select/jenis-transport?onlydarat=1')}}"></select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="nama">Berat Kg</label>
                            <div class="col-sm-8">
                                <input type="number" readonly class="form-control" id="pengepakan_berat" name="pengepakan_berat" value="{{old('pengepakan_berat',isset($biaya->pengepakan_berat) ? $biaya->pengepakan_berat : 0)}}"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="nama">Tarif Rp. / Kg</label>
                            <div class="col-sm-8">
                                <input readonly type="text" class="form-control numeric" id="pengepakan_tarif" name="pengepakan_tarif"  value="{{old('pengepakan_tarif',isset($biaya->pengepakan_tarif) ? number_format($biaya->pengepakan_tarif) : 0)}}"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="nama">Jumlah biaya</label>
                            <div class="col-sm-8">
                                <input readonly type="text" class="form-control numeric" id="pengepakan_biaya" name="pengepakan_biaya" value="{{old('pengepakan_biaya',isset($biaya->pengepakan_biaya) ? number_format($biaya->pengepakan_biaya) : 0)}}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <h6><b>Biaya muat / pengiriman barang</b></h6>
                </div>
                <div class="row">
                    <div class="col-sm-12">
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

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10" class="text-end">
                                            <button title="Tambah biaya muat" type="button" class="muatbarang_add btn btn-sm rounded-pill btn-icon btn-primary">
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
                        <button type="button" class="btn btn-primary btn-stepper-next" data-step="2">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>