@extends('layout._template',['title' => 'Reset Password'])

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<form id="form-user" method="post" enctype="multipart/form-data" action="{{url('reset-password')}}">
    @csrf   
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
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Reset Password</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Username</label>
                        <div class="col-sm-8">
                            <input readonly type="text" class="form-control" minLength="6" onkeydown="return /[^0-9]/i.test(event.key)" id="username" name="username" value="{{old('username',isset($users) ? $users->username : '')}}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="password">Current Password</label>
                        <div class="col-sm-8">
                            <input  type="password" class="form-control" id="cur_password" name="cur_password"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="password">New Password</label>
                        <div class="col-sm-8">
                            <input  type="password" class="form-control" id="password" name="password"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="password">Verifikasi Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password_ver"/>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            
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