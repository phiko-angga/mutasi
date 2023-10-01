@extends('layout._template',['title' => $title])

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<form id="form-user" method="post" enctype="multipart/form-data" action="{{$action == 'store' ? route('paraf.store') : route('paraf.update',$paraf->id)}}">
    
    @csrf   
    @if($action == 'update')
    <input name="_method" type="hidden" value="PUT">
    @endif
    <input type="hidden" name="id" value="{{isset($paraf) ? $paraf->id : ''}}">

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
                        <label class="col-sm-4 col-form-label" for="kode">Penandatangan</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="50" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="kelompok" name="kelompok" value="{{old('kelompok',isset($paraf) ? $paraf->kelompok : '')}}" />
                            <small class="text-info">Max 50</small>
                        </div>
                    </div>
                    <div hidden class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">No. urut</label>
                        <div class="col-sm-8">
                            <input required type="number" class="form-control" id="nourut" name="nourut" value="{{old('nourut',isset($paraf) ? $paraf->nourut : '0')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Nama tertulis</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="50" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="nama" name="nama" value="{{old('nama',isset($paraf) ? $paraf->nama : '')}}" />
                            <small class="text-info">Max 50</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">NIP tertulis</label>
                        <div class="col-sm-8">
                            <input required type="number" max="999999999999999999999999999999" class="form-control" id="nip" name="nip" value="{{old('nip',isset($paraf) ? $paraf->nip : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Kepangkatan</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="50" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="pangkat" name="pangkat" value="{{old('pangkat',isset($paraf) ? $paraf->pangkat : '')}}" />
                            <small class="text-info">Max 50</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Nama jabatan</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="50" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="jabatan" name="jabatan" value="{{old('jabatan',isset($paraf) ? $paraf->jabatan : '')}}" />
                            <small class="text-info">Max 50</small>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{url('paraf')}}" class="btn btn-secondary">back</a>
                            
                        </div>
                    </div>
                    
                    @if($action == 'update')
                    <hr>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal dibuat</label>
                        <div class="col-sm-8">{{$paraf->created_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pembuat</label>
                        <div class="col-sm-8">{{$paraf->created_name}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal diubah</label>
                        <div class="col-sm-8">{{$paraf->updated_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pengubah</label>
                        <div class="col-sm-8">{{$paraf->updated_name}}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
        
</form>
@endsection

@section('script')
    @include('paraf/form_js')
@endsection