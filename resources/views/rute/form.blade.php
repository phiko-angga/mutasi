@extends('layout._template',['title' => $title])

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<form id="form-user" method="post" enctype="multipart/form-data" action="{{$action == 'store' ? route('rute.store') : route('rute.update',$rute->id)}}">
    
    @csrf   
    @if($action == 'update')
    <input name="_method" type="hidden" value="PUT">
    @endif
    <input type="hidden" name="id" value="{{isset($rute) ? $rute->id : ''}}">

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
        <div class="col-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{$title}}</h5>
                </div>
                <div class="card-body">
                    
                <div style="display:none" class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Kode</label>
                        <div class="col-sm-8">
                            <select name="kode" id="kode" class="form-select">
                                @foreach($provinsi as $k)
                                    <option {{isset($rute) ? ($rute->kode == $k->id ? 'selected' : '') : ''}} value="{{$k->id}}">{{$k->kode.' - '.$k->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Provinsi</label>
                        <div class="col-sm-8">
                            <select name="provinsi_id" id="provinsi_id" class="form-select">
                                @foreach($provinsi as $p)
                                    <option {{isset($sbum) ? ($sbum->provinsi_asal_id == $p->id ? 'selected' : '') : ''}} value="{{$p->id}}">{{$p->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Kota</label>
                        <div class="col-sm-8">
                            <select name="kota_id" id="kota_id" class="form-select select2advance" data-select2-placeholder="Kota" data-select2-url="{{url('get-select/kota'.(isset($rute) ? '?provinsi='.$rute->provinsi_id : ''))}}">
                                @isset($rute)
                                    <option value="{{$rute->kota_id}}">{{$rute->kota_nama}}</option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Bus</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input required type="text" maxLength="12" class="form-control numeric" id="bus" name="bus" value="{{old('bus',isset($rute) ? number_format($rute->bus) : '0')}}" />
                            </div>
                            <small class="text-warning">1x Perjalanan</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Laut</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input required type="text" maxLength="12" class="form-control numeric" id="kapal" name="kapal" value="{{old('kapal',isset($rute) ? number_format($rute->kapal) : '0')}}" />
                            </div>
                            <small class="text-warning">1x Perjalanan</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Pesawat Udara</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input required type="text" maxLength="12" class="form-control numeric" id="plane" name="plane" value="{{old('plane',isset($rute) ? number_format($rute->plane) : '0')}}" />
                            </div>
                            <small class="text-warning">1x Perjalanan</small>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{url('rute')}}" class="btn btn-secondary">back</a>
                            
                        </div>
                    </div>
                    
                    @if($action == 'update')
                    <hr>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal dibuat</label>
                        <div class="col-sm-8">{{$rute->created_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pembuat</label>
                        <div class="col-sm-8">{{$rute->created_name}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal diubah</label>
                        <div class="col-sm-8">{{$rute->updated_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pengubah</label>
                        <div class="col-sm-8">{{$rute->updated_name}}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
        
</form>
@endsection

@section('script')
    @include('rute/form_js')
@endsection