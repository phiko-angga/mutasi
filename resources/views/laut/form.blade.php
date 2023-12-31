@extends('layout._template',['title' => $title])

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<form id="form-user" method="post" enctype="multipart/form-data" action="{{$action == 'store' ? route('laut.store') : route('laut.update',$laut->id)}}">
    
    @csrf   
    @if($action == 'update')
    <input name="_method" type="hidden" value="PUT">
    @endif
    <input type="hidden" name="id" value="{{isset($laut) ? $laut->id : ''}}">

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
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama_table">Nama Table Jalur</label>
                        <div class="col-sm-8">
                            <select name="nama_table" id="nama_table" class="form-select">
                                @foreach($table as $t)
                                    <option {{isset($laut) ? ($laut->nama_table == $t->deskripsi ? 'selected' : '') : ''}} value="{{$t->deskripsi}}">{{$t->kode.' - '.$t->deskripsi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h5 class="mb-0">Lokasi Pelabuhan Asal</h5>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Provinsi asal</label>
                        <div class="col-sm-8">
                            <select name="provinsi_asal_id" id="provinsi_asal_id" class="form-select">
                                @foreach($provinsi as $p)
                                    <option {{isset($laut) ? ($laut->provinsi_asal_id == $p->id ? 'selected' : '') : ''}} value="{{$p->id}}">{{$p->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Pelabuhan asal</label>
                        <div class="col-sm-8">
                            <select name="kota_asal_id" id="kota_asal_id" class="form-select select2advance" data-select2-placeholder="Pelabuhan asal" data-select2-url="{{url('get-select/kota').(isset($sbum) ? '?provinsi='.$sbum->provinsi_asal_id : '')}}">
                                @isset($laut)
                                    <option value="{{$laut->kota_asal_id}}">{{$laut->kotaa_nama}}</option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    
                    <h5 class="mb-0">Lokasi Pelabuhan Tujuan</h5>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Provinsi tujuan</label>
                        <div class="col-sm-8">
                            <select name="provinsi_tujuan_id" id="provinsi_tujuan_id" data-kota_exclude="1" class="form-select select2advance" data-select2-placeholder="Provinsi tujuan" data-select2-url="{{url('get-select/provinsi')}}">
                                @isset($laut)
                                    <option value="{{$laut->provinsi_tujuan_id}}">{{$laut->provinsit_nama}}</option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Pelabuhan tujuan</label>
                        <div class="col-sm-8">
                            <select name="kota_tujuan_id" id="kota_tujuan_id" class="form-select select2advance" data-select2-placeholder="Pelabuhan tujuan" data-select2-url="{{url('get-select/kota').(isset($laut) ? '?provinsi='.$laut->provinsi_tujuan_id : '')}}">
                                @isset($laut)
                                    <option value="{{$laut->kota_tujuan_id}}">{{$laut->kotat_nama}}</option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Jarak (Mil)</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="10" onkeydown="return /[0-9,Backspace]/i.test(event.key)" class="form-control" id="jarak_mil" name="jarak_mil" value="{{old('jarak_mil',isset($laut) ? $laut->jarak_mil : '0')}}" />
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{url('laut')}}" class="btn btn-secondary">back</a>
                            
                        </div>
                    </div>
                    
                    @if($action == 'update')
                    <hr>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal dibuat</label>
                        <div class="col-sm-8">{{$laut->created_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pembuat</label>
                        <div class="col-sm-8">{{$laut->created_name}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal diubah</label>
                        <div class="col-sm-8">{{$laut->updated_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pengubah</label>
                        <div class="col-sm-8">{{$laut->updated_name}}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
        
</form>
@endsection

@section('script')
    @include('laut/form_js')
@endsection