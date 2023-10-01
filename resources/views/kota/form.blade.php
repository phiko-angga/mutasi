@extends('layout._template',['title' => $title])

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<form id="form-user" method="post" enctype="multipart/form-data" action="{{$action == 'store' ? route('kota.store') : route('kota.update',$kota->id)}}">
    
    @csrf   
    @if($action == 'update')
    <input name="_method" type="hidden" value="PUT">
    @endif
    <input type="hidden" name="id" value="{{isset($kota) ? $kota->id : ''}}">

    @if($errors->any() || (\Session::has('success')) )
    <div class="row">
        <div class="col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    
                    @if($errors->any())
                    <div class="form-group">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{$errors->first()}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    @if (\Session::has('success'))
                    <div class="form-group">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sukses!</strong> {!! \Session::get('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
    @endif

    <div class="row">
        <!-- Basic Layout -->
        <div class="col-12 col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{$title}}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Kode</label>
                        <div class="col-sm-8">
                            <input maxlength="5" readonly type="text" class="form-control" id="kode" name="kode" value="{{old('kode',isset($kota) ? $kota->kode : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Provinsi</label>
                        <div class="col-sm-8">
                            <select name="provinsi_id" id="provinsi_id" class="form-select">
                                @foreach($provinsi as $p)
                                    <option {{isset($kota) ? ($kota->provinsi_id == $p->id ? 'selected' : '') : ''}} value="{{$p->id}}">{{$p->nama}} - {{$p->kode}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Kabupaten / Kota</label>
                        <div class="col-sm-8">
                            <input required  style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" onkeydown="return /[^0-9]/i.test(event.key)" type="text" maxlength="50" class="form-control" id="nama" name="nama" value="{{old('nama',isset($kota) ? $kota->nama : '')}}" />
                            <small class="text-info">Max 50</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="alamat">Alamat</label>
                        <div class="col-sm-8">
                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="3">{{old('alamat',isset($kota) ? $kota->alamat : '')}}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kodepos">Telepon</label>
                        <div class="col-sm-8">
                            <input type="number" max="999999999999999" class="form-control" id="telepon" name="telepon" value="{{old('telepon',isset($kota) ? $kota->telepon : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kodepos">kode POS</label>
                        <div class="col-sm-8">
                            <input type="text" maxLength="10" onkeydown="return /[^a-zA-Z]/i.test(event.key)" class="form-control" id="kodepos" name="kodepos" maxlength="10" value="{{old('kodepos',isset($kota) ? $kota->kodepos : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="password">Status</label>
                        <div class="col-sm-8 d-flex">
                            <div class="form-check me-3">
                                <input name="status" class="form-check-input" type="radio" value="0" id="status0"  {{old('status',isset($kota) ? ($kota->status == 0 ? 'checked' : '') : '')}}>
                                <label class="form-check-label" for="defaultRadio1"> Tidak aktif </label>
                            </div>
                            <div class="form-check">
                                <input name="status" class="form-check-input" type="radio" value="1" id="status1"  {{old('status',isset($kota) ? ($kota->status == 1 ? 'checked' : '') : 'checked')}}>
                                <label class="form-check-label" for="defaultRadio2"> Aktif </label>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{url('kota')}}" class="btn btn-secondary">back</a>
                            
                        </div>
                    </div>
                    
                    @if($action == 'update')
                    <hr>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal dibuat</label>
                        <div class="col-sm-8">{{$kota->created_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pembuat</label>
                        <div class="col-sm-8">{{$kota->created_name}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal diubah</label>
                        <div class="col-sm-8">{{$kota->updated_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pengubah</label>
                        <div class="col-sm-8">{{$kota->updated_name}}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Ketersediaan</h5>
                </div>
                <div class="card-body">
                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kantor">Kantor PN</label>
                        <div class="col-sm-8 d-flex">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="kantor" id="kantor" {{old('kantor',isset($kota) ? ($kota->kantor == 1 ? 'checked' : '') : '')}}>
                            <label class="form-check-label" for="kantor"> Checked </label>
                          </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kantor">Ibu Kota Prov.</label>
                        <div class="col-sm-8 d-flex">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="ibukota_prov" id="ibukota_prov" {{old('ibukota_prov',isset($kota) ? ($kota->ibukota_prov == 1 ? 'checked' : '') : '')}}>
                            <label class="form-check-label" for="kantor"> Checked </label>
                          </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="bandara">Bandara</label>
                        <div class="col-sm-8 d-flex">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="bandara" id="bandara" {{old('bandara',isset($kota) ? ($kota->bandara == 1 ? 'checked' : '') : '')}}>
                            <label class="form-check-label" for="bandara"> Checked </label>
                          </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="pelabuhan">Pelabuhan</label>
                        <div class="col-sm-8 d-flex">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="pelabuhan" id="pelabuhan" {{old('pelabuhan',isset($kota) ? ($kota->pelabuhan == 1 ? 'checked' : '') : '')}}>
                            <label class="form-check-label" for="pelabuhan"> Checked </label>
                          </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="stasiun">Stasiun</label>
                        <div class="col-sm-8 d-flex">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="stasiun" id="stasiun" {{old('stasiun',isset($kota) ? ($kota->stasiun == 1 ? 'checked' : '') : '')}}>
                            <label class="form-check-label" for="stasiun"> Checked </label>
                          </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="terminal">Terminal</label>
                        <div class="col-sm-8 d-flex">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="terminal" id="terminal" {{old('terminal',isset($kota) ? ($kota->terminal == 1 ? 'checked' : '') : '')}}>
                            <label class="form-check-label" for="terminal"> Checked </label>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
        
</form>
@endsection

@section('script')
    @include('kota/form_js')
@endsection