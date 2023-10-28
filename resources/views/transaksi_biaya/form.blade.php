@extends('layout._template',['title' => $title])

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css" rel="stylesheet" />

@endsection

@section('content')

<form id="form-transaksi" method="post" enctype="multipart/form-data" action="{{$action == 'store' ? route('transaksi-biaya.store') : route('transaksi-biaya.update',$biaya->id)}}">
    <input type="hidden" id="bendaharawan_list" value="{{$bendaharawan}}">
    <input type="hidden" id="kuasaanggaran_list" value="{{$kuasaanggaran}}">
    <input type="hidden" id="penerima_list" value="{{$penerima}}">
    <input type="hidden" id="ppk_list" value="{{$ppk}}">
    <input type="hidden" id="keluarga_list" value="{{isset($biaya) ? $biaya->keluarga : '[]'}}">
    <input type="hidden" id="transport_list" value="{{isset($biaya) ? $biaya->transport : '[]'}}">
    <input type="hidden" id="transport_pembantu_list" value="{{isset($biaya) ? $biaya->transport_pembantu : '[]'}}">
    <input type="hidden" id="muatbarang_list" value="{{isset($biaya) ? $biaya->muat : '[]'}}">
    <input type="hidden" id="today" value="{{Carbon\Carbon::parse(date('Y-m-d'))->formatLocalized('%d %B %Y')}}">
    @csrf   
    @if($action == 'update')
    <input name="_method" type="hidden" value="PUT">
    @endif
    <input type="hidden" name="id" value="{{isset($biaya) ? $biaya->id : ''}}">

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
    <div class="bs-stepper">
        <div class="bs-stepper-header" role="tablist">
            <!-- your steps here -->
            <div class="step" data-target="#datapegawai-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="datapegawai-part" id="datapegawai-part-trigger">
                    <span class="bs-stepper-circle" style="height: 2.3em;width: 2.3em;border-radius: 2.3em;">
                        <i class="menu-icon tf-icons bx bx-user" style="margin-right: 0;"></i>
                    </span>
                    <span class="bs-stepper-label">Data Pegawai - SPD</span>
                </button>
            </div>
            <div class="line"></div>

            <div class="step" data-target="#transport-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="transport-part" id="transport-part-trigger">
                    <span class="bs-stepper-circle" style="height: 2.3em;width: 2.3em;border-radius: 2.3em;">
                        <i class="menu-icon tf-icons bx bx-paper-plane" style="margin-right: 0;"></i>
                    </span>
                    <span class="bs-stepper-label">Biaya Transportasi</span>
                </button>
            </div>
            <div class="line"></div>

            <div class="step" data-target="#muatbarang-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="muatbarang-part" id="muatbarang-part-trigger">
                    <span class="bs-stepper-circle" style="height: 2.3em;width: 2.3em;border-radius: 2.3em;">
                        <i class="menu-icon tf-icons bx bx-car" style="margin-right: 0;"></i>
                    </span>
                    <span class="bs-stepper-label">Biaya Muat Barang</span>
                </button>
            </div>
            <div class="line"></div>

            <div class="step" data-target="#uangh-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="uangh-part" id="uangh-part-trigger">
                    <span class="bs-stepper-circle" style="height: 2.3em;width: 2.3em;border-radius: 2.3em;">
                        <i class="menu-icon tf-icons bx bx-money" style="margin-right: 0;"></i>
                    </span>
                    <span class="bs-stepper-label">Uang Harian/Rampung</span>
                </button>
            </div>
        </div>
        <div class="bs-stepper-content">
                <!-- your steps content here -->
                <div id="datapegawai-part" class="content" role="tabpanel" aria-labelledby="datapegawai-part-trigger">
                    @include('transaksi_biaya.biaya_data_pegawai')
                </div>
                <div id="transport-part" class="content" role="tabpanel" aria-labelledby="transport-part-trigger">
                    @include('transaksi_biaya.biaya_transport')
                </div>
                <div id="muatbarang-part" class="content" role="tabpanel" aria-labelledby="muatbarang-part-trigger">
                    @include('transaksi_biaya.biaya_muatbarang')
                </div>
                <div id="uangh-part" class="content" role="tabpanel" aria-labelledby="uangh-part-trigger">
                    @include('transaksi_biaya.biaya_uangh')
                </div>
        </div>
    </div>
</form>
@endsection

@section('script')
    @include('transaksi_biaya/form_js')
@endsection