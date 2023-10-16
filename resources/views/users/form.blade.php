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
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{$title}}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Username</label>
                        <div class="col-sm-8">
                            <input required type="text" class="form-control" minLength="6" onkeydown="return /[^0-9]/i.test(event.key)" id="username" name="username" value="{{old('username',isset($users) ? $users->username : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kode">Nama Lengkap</label>
                        <div class="col-sm-8">
                            <input type="text" maxLength="60" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="fullname" name="fullname" value="{{old('fullname',isset($users) ? $users->fullname : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Jabatan</label>
                        <div class="col-sm-8">
                            <input type="text" maxLength="60" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="jabatan" name="jabatan" value="{{old('jabatan',isset($users) ? $users->jabatan : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Catatan</label>
                        <div class="col-sm-8">
                            <input type="text" maxLength="60" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="catatan" name="catatan" value="{{old('catatan',isset($users) ? $users->catatan : '')}}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Departemen</label>
                        <div class="col-sm-8">
                            <input type="text" maxLength="60" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="depname" name="depname" value="{{old('depname',isset($users) ? $users->depname : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Divisi</label>
                        <div class="col-sm-8">
                            <input type="text" maxLength="60" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="divname" name="divname" value="{{old('divname',isset($users) ? $users->divname : '')}}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nama">Seksi</label>
                        <div class="col-sm-8">
                            <input type="text" maxLength="60" onkeydown="return /[^0-9]/i.test(event.key)" class="form-control" id="secname" name="secname" value="{{old('secname',isset($users) ? $users->secname : '')}}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="password">Status</label>
                        <div class="col-sm-8 d-flex">
                            <div class="form-check me-3">
                                <input {{old('status',isset($users) ? $users->status : '') == '0' ? 'checked' : ''}} name="status" class="form-check-input" type="radio" value="0" id="status0">
                                <label class="form-check-label" for="defaultRadio1"> Tidak aktif </label>
                            </div>
                            <div class="form-check">
                                <input {{old('status',isset($users) ? $users->status : '1') == '1' ? 'checked' : ''}} name="status" class="form-check-input" type="radio" value="1" id="status1">
                                <label class="form-check-label" for="defaultRadio2"> Aktif </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="password">Password</label>
                        <div class="col-sm-8">
                            <input  {{$action == 'store' ? 'required' : ''}} type="password" class="form-control" id="password" name="password"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="password">Verifikasi Password</label>
                        <div class="col-sm-8">
                            <input  {{$action == 'store' ? 'required' : ''}} type="password" class="form-control" id="password_ver"/>
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

        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Menu Akses</h5>
                </div>
                <div class="card-body">
                    @foreach($menu_grup as $key => $grup)
                        <div class="row mb-3">
                            <h6 class="col-sm-4">{{$grup->grup}}</h6>
                            @php
                                $menu2 = clone $menu;
                                $menuPerGrup = $menu2->where('grup',$grup->grup);
                            @endphp
                            @if($menuPerGrup)
                                @foreach($menuPerGrup as $m)
                                <label class="col-sm-4 col-form-label" for="password"></label>
                                <div class="col-sm-8 d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{$m->curmenu != 0 ? 'checked' : ''}} value="{{$m->id}}" name="menu[]" id="menu_{{$m->id}}">
                                        <label class="form-check-label" for="menu_{{$m->id}}"> {{$m->nama}} </label>
                                    
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <hr>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
        
</form>
@endsection

@section('script')
    @include('users/form_js')
@endsection