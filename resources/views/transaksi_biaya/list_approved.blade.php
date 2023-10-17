@extends('layout._template',['title' => $page])

@section('style')
<style>
    .swal2-container {
        z-index: 20000 !important;
    }
    
    table{
        border-collapse: collapse;
    }
     .header th {
        position: sticky;
        top:0;
        background-color: white;
    }
</style>
@endsection

@section('content')

<div class="row">

	<div class="col-md-12 grid-margin stretch-card">
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

                @if (\Session::has('info'))
                <div class="form-group">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong> {!! \Session::get('info') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif
                
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex justify-content-between align-items-end flex-wrap">
                            <div class=" me-3">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="menu-icon tf-icons bx bx-printer"></i> Print
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                        <a class="dropdown-item print_pdf" data-url="{{url('transaksi_biaya_print_pdf')}}" href="javascript:void(0);">PDF</a>
                                        <a class="dropdown-item print_excel" data-url="{{url('transaksi_biaya_print_excel')}}" href="javascript:void(0);">EXCEL</a>
                                    </div>
                                </div>
                            </div>
                            <div class=" me-3 ms-auto"><input value="{{isset($search) ? $search : ''}}" type="text" id="search" name="search" class="form-control form-control-sm" placeholder="Search"  autofocus></div>
                            
                        </div>
                    </div>
                </div>
                <div class="table-responsive row-table">
                    <table class="table">
                        <thead class="header">
                            <tr>
                                <th width="5%">No.</th>
                                <th style="width:10%">Nomor</th>
                                <th style="width:10%">Nama Pegawai</th>
                                <th style="width:10%">NIP Pegawai</th>
                                <th style="width:10%">pangkat Gol. Ruang Gaji</th>
                                <th style="width:10%">Status Kawin</th>
                                <th style="width:10%">Jabatan/Instansi</th>
                                <th style="width:10%">Nama Jabatan</th>
                                <th style="width:10%">Kelompok Jabatan</th>
                                <th style="width:10%">Total Biaya</th>
                                <th style="">Di approve oleh</th>
                                <th style="">Tanggal approve</th>
                            </tr>
                        </thead>
                        @include('transaksi_biaya.list_approved_pagination')
                    </table>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="clearfix"></div>
</div><!-- /.row -->

@include('helper.modal_confirm')

@endsection

@section('script')
<script>
    
    $(document).on('change','#search', function(){
        fetch_tabledata('/transaksi_biaya/approved-list');
    })
</script>
@endsection