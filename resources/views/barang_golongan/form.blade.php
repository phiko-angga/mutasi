@extends('layout._template',['title' => $title])

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<form id="form-user" method="post" enctype="multipart/form-data" action="{{$action == 'store' ? route('barang-golongan.store') : route('barang-golongan.update',$barang->id)}}">
    
    @csrf   
    @if($action == 'update')
    <input name="_method" type="hidden" value="PUT">
    @endif
    <input type="hidden" name="id" value="{{isset($barang) ? $barang->id : ''}}">

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
                        <label class="col-sm-4 col-form-label" for="kode">Golongan</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="10" class="form-control" id="golongan" name="golongan" value="{{old('golongan',isset($barang->golongan) ? $barang->golongan : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Bujangan</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="3" class="form-control numeric" id="bujangan" name="bujangan" value="{{old('bujangan',isset($barang->bujangan) ? number_format($barang->bujangan) : '0')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Keluarga</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="3" class="form-control numeric" id="keluarga" name="keluarga" value="{{old('keluarga',isset($barang->keluarga) ? number_format($barang->keluarga) : '0')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Anak 1</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="3" class="form-control numeric" id="anak1" name="anak1" value="{{old('anak1',isset($barang->anak1) ? number_format($barang->anak1) : '0')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Anak 2</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="3" class="form-control numeric" id="anak2" name="anak2" value="{{old('anak2',isset($barang->anak2) ? number_format($barang->anak2) : '0')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Anak 3+</label>
                        <div class="col-sm-8">
                            <input required type="text" maxLength="3" class="form-control numeric" id="anak3" name="anak3" value="{{old('anak3',isset($barang->anak3) ? number_format($barang->anak3) : '0')}}" />
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{url('barang-golongan')}}" class="btn btn-secondary">back</a>
                            
                        </div>
                    </div>
                    
                    @if($action == 'update')
                    <hr>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal dibuat</label>
                        <div class="col-sm-8">{{$barang->created_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pembuat</label>
                        <div class="col-sm-8">{{$barang->created_name}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Tanggal diubah</label>
                        <div class="col-sm-8">{{$barang->updated_at}}</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="alias">Nama pengubah</label>
                        <div class="col-sm-8">{{$barang->updated_name}}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
        
</form>
@endsection

@section('script')
    @include('biaya_transport/form_js')
@endsection