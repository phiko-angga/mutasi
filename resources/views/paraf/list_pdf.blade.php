@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>NIP</th>
                        <th>Kepangkatan</th>
                        <th>Nama jabatan</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($data) !== 0)
                    @foreach($data as $key => $row)
                    <tr>
                        <td>{{ (++$key)}}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->nip }}</td>
                        <td>{{ $row->pangkat }}</td>
                        <td>{{ $row->jabatan }}</td>
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
