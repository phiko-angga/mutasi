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
                            <div class=" me-3"><a href="{{route('transaksi-biaya.create')}}" class="btn btn-outline-primary btn-fw btn-sm">Tambah data</a></div>
                            <div class=" me-3">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="menu-icon tf-icons bx bx-printer"></i> Print
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
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
                                <th>Nama Pegawai</th>
                                <th>NIP Pegawai</th>
                                <th>Pangkat Gol. Ruang Gaji</th>
                                <th>Status Kawin</th>
                                <th>Jabatan / Instansi</th>
                                <th>Nama Jabatan</th>
                                <th>Kelompok Jabatan</th>
                                <th>Total Biaya</th>
                                <th>Tingkat Perjalanan Dinas</th>
                                <th>Jumlah Ikut</th>
                                <th style="width:250px">Maksud Perjalanan Dinas</th>
                                <th>Alat Angkutan (jenis transportasi)</th>
                                <th>Tempat Berangkat</th>
                                <th>Provinsi Berangkat</th>
                                <th>Tempat Tujuan</th>
                                <th>Provinsi Tujuan</th>
                                <th>Lama Perjalanan</th>
                                <th>Tgl Berangkat</th>
                                <th>Tgl Tiba</th>
                                <th>Pejabat Berwenang Pemberi Perintah</th>
                                <th>Pembebanan Biaya - Instansi</th>
                                <th>Pembebanan Biaya - Mata Anggaran</th>
                                <th>Tertanggal</th>
                                <th>Nama PPK</th>
                                <th>NIP PPK</th>
                                <th>Keterangan lain - lain</th>
                                <th>Tgl Dievaluasi</th>
                                <th>Nama Evaluasi Data</th>
                                <th>Tanggal dibuat</th>
                                <th>Nama pembuat</th>
                                <th>Tanggal diubah</th>
                                <th>Nama pengubah</th>
                                <th></th>
                            </tr>
                        </thead>
                        @include('transaksi_biaya.list_pagination')
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
    
    $(document).on('change','#search, #show-per-page', function(){
        fetch_tabledata('/transaksi_biaya');
    })

    
    $(document).on('click','.delete_btn',function(e){
        e.preventDefault();
        var modalConfirm = $('#modal_confirm');
        modalConfirm.find('form').attr('action','{{url('')}}/transaksi-biaya/'+$(this).data('id'));
        modalConfirm.find('#confirm_title').html('Delete data ');
        modalConfirm.find('#confirm_titlecaption').html('Anda yakin ingin menghapus sebuah surat perjalanan dinas sebagai berikut : ');

        let content = [
            '<ul>',
                '<li>',
                    '<div class="d-flex">',
                        '<p style="width:90px"> Nama',
                            '<span style="float:right"> : &nbsp;&nbsp;',
                        '</p>',
                        $(this).data('nama'),
                    '</div>',
                '</li>',
                '<li>',
                    '<div class="d-flex">',
                        '<p style="width:90px"> NIP',
                            '<span style="float:right"> : &nbsp;&nbsp;',
                        '</p>',
                        $(this).data('nip'),
                    '</div>',
                '</li>',
                '<li>',
                    '<div class="d-flex">',
                        '<p style="width:90px"> Tanggal',
                            '<span style="float:right"> : &nbsp;&nbsp;',
                        '</p>',
                        $(this).data('tanggal'),
                    '</div>',
                '</li>',
                '<li>',
                    '<div class="d-flex">',
                        '<p style="width:90px"> Nomor',
                            '<span style="float:right"> : &nbsp;&nbsp;',
                        '</p>',
                        $(this).data('nomor'),
                    '</div>',
                '</li>',
            '</ul>',
        ]

        modalConfirm.find('#confirm_content').html(content.join(""));
        modalConfirm.find('#confirm_titlebtn').html('Delete');
        modalConfirm.find('#id').val($(this).data('id'));
        modalConfirm.modal('show');
    })

    $('.btn-approve').click(function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let token = $('input[name="_token"]').val();

        //Get Detail
        let params = {};
        params.url = "/transaksi-biaya/"+id;
        params.data = {_token:token};
        params.type = 'get';
        params.result = function(data){ 
            // console.log(data);
            loadDetail(data);
        }
        ajaxCall(params);
    })

    $(document).on('click','.btn-approve-confirm',function(e){
        e.preventDefault();
        console.log('approve-confirm');
        
        let param = {};
        param.pesan = "Yakin ingin approve ?";
        param.response = function(result){
        
            if (result.isConfirmed) {
                $("#form-modal-approve").submit();
            }
        };
        show_confirm(param);
    })

    function loadDetail(data){
        
        $("body").find("#approve-modal").remove();
        $("body").append(data);
        let form = $("#approve-modal");
        form.modal('show');
        // $('.table-history-suara tbody').html('');
        // $('.table-history-suara tbody').append(data);
    }

</script>
@endsection