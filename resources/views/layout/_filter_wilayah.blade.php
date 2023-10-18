
<div class="row">
    <div class="col-md-12 col-sm-12 grid-margin stretch-card mb-3">
        <div class="card">
            <div class="card-body p-1">

                <div class="row w-100" style="align-items: center;min-height:40px;">
                    <div class="col-2 h-100 d-flex align-items-center">
                        <span class="ms-2 btn btn-sm btn-primary w-100"><i class="menu-icon tf-icons bx bx-filter-alt"></i> <span class="d-none d-sm-inline">Filter</span></span>
                    </div>
                    <div class="col-10 h-100">
                        <div class="row h-100">
                            <div class="col-md-3 h-100 py-1">
                                <div class="form-group h-100">
                                    <select form="form-list" style="width:100%" class="form-select select2advance" id="provinsi_id" data-select2-placeholder="Pilih provinsi" data-select2-url="{{ url('get-select/provinsi') }}" aria-label="Default select example">
                                        
                                        @isset($filter_provinsi)
                                            <option value="{{$filter_provinsi->id}}">{{$filter_provinsi->nama}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>