@extends('layout._template',['title' => $title])

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<form id="form-user" method="post" enctype="multipart/form-data" action="{{$action == 'store' ? route('users.store') : route('users.update',$users->id)}}">
    
    @csrf   
    @if($action == 'update')
    <input name="_method" type="hidden" value="PUT">
    @endif
    <input type="hidden" name="id" value="{{isset($users) ? $users->id : ''}}">

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
        <div class="col-7 col-md-7">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{$title}}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Nama Lengkap</label>
                        <div class="col-sm-8">
                            <input required type="text" class="form-control" id="name" name="name" value="{{old('name',isset($users) ? $users->name : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Username</label>
                        <div class="col-sm-8">
                            <input required type="text" class="form-control" id="username" name="username" value="{{old('username',isset($users) ? $users->username : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="password">Password</label>
                        <div class="col-sm-8">
                            <input  {{$action == 'store' ? 'required' : ''}} type="password" class="form-control" id="password" name="password"/>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            
                            @if($action == 'update')
                            <button type="button" class="btn btn-secondary btn-savetoken" title="Agar dapat menerima realtime notifkasi">Save token</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5 col-md-5">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Koordinator Wilayah</h5>
                </div>
                <div class="card-body">
                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Provinsi</label>
                        <div class="col-sm-8">
                            <select class="form-select select2advance" name="provinsi_id" id="provinsi_id" data-select2-placeholder="Pilih provinsi" data-select2-url="{{url('get-select/provinsi')}}" aria-label="Default select example"> 
                                
                                @isset($users)
                                    <option value="{{$users->provinsi_id}}">{{$users->provinsi}}</option>
                                @elseisset
                                    <option value=""></option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Kabupaten / Kota</label>
                        <div class="col-sm-8">
                            <select class="form-select select2advance" name="kota_id" id="kota_id" data-select2-placeholder="Pilih kota / kabupaten" data-select2-url="{{url('get-select/kota'.(isset($users) ? '?provinsi='.$users->provinsi_id : ''))}}" aria-label="Default select example"> 
                                
                                @isset($users)
                                    <option value="{{$users->kota_id}}">{{$users->kota}}</option>
                                @elseisset
                                    <option value=""></option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Kecamatan</label>
                        <div class="col-sm-8">
                            <select class="form-select select2advance" name="kecamatan_id" id="kecamatan_id" data-select2-placeholder="Pilih kecamatan" data-select2-url="{{url('get-select/kecamatan'.(isset($users) ? '?kota='.$users->kota_id : ''))}}" aria-label="Default select example"> 
                               
                                @isset($users)
                                    <option value="{{$users->kecamatan_id}}">{{$users->kecamatan}}</option>
                                @elseisset
                                    <option value=""></option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Desa / Kelurahan</label>
                        <div class="col-sm-8">
                            <select class="form-select select2advance" name="kelurahan_id" id="kelurahan_id" data-select2-placeholder="Pilih desa / kelurahan" data-select2-url="{{url('get-select/kelurahan'.(isset($users) ? '?kecamatan='.$users->kecamatan_id : ''))}}" aria-label="Default select example"> 
                                
                                @isset($users)
                                    <option value="{{$users->kelurahan_id}}">{{$users->kelurahan}}</option>
                                @elseisset
                                    <option value=""></option>
                                @endisset
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</form>
@endsection

@section('script')
    @include('users/form_js')
@endsection