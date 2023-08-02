@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Koordinator Wilayah</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($users) !== 0)
                    @foreach($users as $key => $row)
                    <tr>
                        <td>{{ (++$key)}}</td>
                        <td><strong>{{ $row->username }}</strong></td>
                        <td>{{ $row->name }}</td>
                        <td>
                            @if($row->provinsi_id == null && $row->kota_id == null && $row->kecamatan_id == null && $row->kelurahan_id == null)
                            <span class="badge rounded-pill bg-label-primary mb-0">ADMIN UTAMA</span>
                            @else
                            
                            <span class="badge rounded-pill bg-label-primary mb-0">Provinsi :</span> 
                            <span>{{ $row->provinsi }}</span>
                            <br>
                            <span style="font-size:10px" class="badge rounded-pill bg-label-primary mb-0">Kabupaten / Kota :</span>
                            <span>{{ $row->kota }}</span>
                            <br>
                            <span style="font-size:10px" class="badge rounded-pill bg-label-primary mb-0">Kecamatan :</span>
                            <span>{{ $row->kecamatan }}</span>
                            <br>
                            <span style="font-size:10px" class="badge rounded-pill bg-label-primary mb-0">Desa / Kelurahan :</span>
                            <span>{{ $row->kelurahan }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" align="center">
                            <h4 class="text-center">No Data Available</h4>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
