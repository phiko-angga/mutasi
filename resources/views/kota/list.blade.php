@extends('layout._template',['title' => 'Kota'])

@section('style')
<style>
    
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
                            <div class=" me-3"><a href="{{route('kota.create')}}" class="btn btn-outline-primary btn-fw btn-sm">Tambah data</a></div>
                            <div class=" me-3">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="menu-icon tf-icons bx bx-printer"></i> Print
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                        <a class="dropdown-item print_pdf" data-url="{{url('kota_print_pdf')}}" href="javascript:void(0);">PDF</a>
                                        <a class="dropdown-item print_excel" data-url="{{url('kota_print_excel')}}" href="javascript:void(0);">EXCEL</a>
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
                                <th style="width:15%">Kode</th>
                                <th>kota</th>
                                <th>Provinsi</th>
                                <th>Kantor PN</th>
                                <th>Ibu Kota Prov.</th>
                                <th>Bandara</th>
                                <th>Pelabuhan</th>
                                <th>Stasiun</th>
                                <th>Terminal</th>
                                <th>Status</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Kode POS</th>
                                <th>Tanggal dibuat</th>
                                <th>Nama pembuat</th>
                                <th>Tanggal diubah</th>
                                <th>Nama pengubah</th>
                                <th></th>
                            </tr>
                        </thead>
                        @include('kota.list_pagination')
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
        fetch_tabledata('/kota');
    })

    
    $(document).on('click','.delete_btn',function(e){
        e.preventDefault();
        var modalConfirm = $('#modal_confirm');
        modalConfirm.find('form').attr('action','{{url('')}}/kota/'+$(this).data('id'));
        modalConfirm.find('#confirm_title').html('Delete data ');
        modalConfirm.find('#confirm_titlecaption').html('Apakah anda ingin delete ');
        modalConfirm.find('#confirm_titlename').html($(this).data('name'));
        modalConfirm.find('#confirm_titlebtn').html('Delete');
        modalConfirm.find('#id').val($(this).data('id'));
        modalConfirm.modal('show');
    })

</script>
@endsection