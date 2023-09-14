@extends('layout._template',['title' => 'Laut'])

@section('style')
<style>
    
    table{
        border-collapse: collapse;
    }
    .row-table{
        height: 400px;
        overflow: auto;
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
                            <div class=" me-3"><a href="{{route('laut.create')}}" class="btn btn-outline-primary btn-fw btn-sm">Tambah data</a></div>
                            <div class=" me-3">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="menu-icon tf-icons bx bx-printer"></i> Print
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                        <a class="dropdown-item print_pdf" data-url="{{url('laut_print_pdf')}}" href="javascript:void(0);">PDF</a>
                                        <a class="dropdown-item print_excel" data-url="{{url('laut_print_excel')}}" href="javascript:void(0);">EXCEL</a>
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
                                <th style="width:10%">Provinsi Asal</th>
                                <th style="width:10%">Pelabuhan Asal</th>
                                <th style="width:10%">Provinsi Tujuan</th>
                                <th style="width:10%">Pelabuhan Tujuan</th>
                                <th style="">Jarak (Mil)</th>
                                <th style="">Nama Table</th>
                                <th style="">Tanggal dibuat</th>
                                <th style="">Nama pembuat</th>
                                <th style="">Tanggal diubah</th>
                                <th style="">Nama pengubah</th>
                                <th></th>
                            </tr>
                        </thead>
                        @include('laut.list_pagination')
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
        fetch_tabledata('/laut');
    })

    $('.delete_btn').click(function(e){
        e.preventDefault();
        var modalConfirm = $('#modal_confirm');
        modalConfirm.find('form').attr('action','{{url('')}}/laut/'+$(this).data('id'));
        modalConfirm.find('#confirm_title').html('Delete data ');
        modalConfirm.find('#confirm_titlecaption').html('Apakah anda ingin delete ');
        modalConfirm.find('#confirm_titlename').html($(this).data('name'));
        modalConfirm.find('#confirm_titlebtn').html('Delete');
        modalConfirm.find('#id').val($(this).data('id'));
        modalConfirm.modal('show');
    })

</script>
@endsection