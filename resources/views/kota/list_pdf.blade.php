@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Kota</th>
                        <th>Provinsi</th>
                        <th>Tanggal diubah</th>
                        <th>Nama pengubah</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($data) !== 0)
                    @foreach($data as $key => $row)
                    <tr>
                        <td>{{ (++$key)}}</td>
                        <td><strong>{{ $row->kode }}</strong></td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->provinsi_nama }}</td>
                        <td>{{ $row->updated_at }}</td>
                        <td>{{ $row->updated_name }}</td>
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
