<div class="row">
    <!-- Basic Layout -->
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
            <div class="col-md-12">
                    <h6><b>Biaya pengepakan / penggudangan</b></h6>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <select name="pengepakan_transport_id" id="pengepakan_transport_id" class="form-select select2advance" data-select2-placeholder="Jenis transport" data-select2-url="{{url('get-select/jenis-transport')}}"></select>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control numeric" id="pengepakan_berat" name="pengepakan_berat" />
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control numeric" id="pengepakan_tarif" name="pengepakan_tarif" />
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control numeric" id="pengepakan_biaya" name="pengepakan_biaya" />
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
                                        <td colspan="9" class="text-end">
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
                        <button type="button" class="btn btn-primary" onclick="stepper.next()">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>