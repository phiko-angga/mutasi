@extends('layout._template',['title' => 'Daftar User'])

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
                            <div class=" me-3"><a href="{{route('users.create')}}" class="btn btn-outline-primary btn-fw btn-sm">Tambah data</a></div>
                            <div class=" me-3">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="menu-icon tf-icons bx bx-printer"></i> Print
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                        <a class="dropdown-item print_pdf" data-url="{{url('users_print_pdf')}}" href="javascript:void(0);">PDF</a>
                                        <a class="dropdown-item print_excel" data-url="{{url('users_print_excel')}}" href="javascript:void(0);">EXCEL</a>
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
                                <th width="5%"></th>
                                <th style="width:15%">Username</th>
                                <th>Nama Lengkap</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @include('users.list_pagination')
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
        fetch_tabledata('/users');
    })

    $('.delete_btn').click(function(e){
        e.preventDefault();
        var modalConfirm = $('#modal_confirm');
        modalConfirm.find('form').attr('action','{{url('')}}/users/'+$(this).data('id'));
        modalConfirm.find('#confirm_title').html('Delete users ');
        modalConfirm.find('#confirm_titlecaption').html('Apakah anda ingin delete ');
        modalConfirm.find('#confirm_titlename').html($(this).data('name'));
        modalConfirm.find('#confirm_titlebtn').html('Delete');
        modalConfirm.find('#id').val($(this).data('id'));
        modalConfirm.modal('show');
    })

</script>
@endsection