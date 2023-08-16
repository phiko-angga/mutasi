@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelabuhan Asal</th>
                        <th>Provinsi Asal</th>
                        <th>Pelabuhan Tujuan</th>
                        <th>Provinsi Tujuan</th>
                        <th>Jarak (Mil)</th>
                        <th>Nama Table</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($data) !== 0)
                    @foreach($data as $key => $row)
                    <tr>
                        <td>{{ (++$key)}}</td>
                        <td>{{ $row->pelabuhan_asal }}</td>
                        <td>{{ $row->provinsia_nama }}</td>
                        <td>{{ $row->pelabuhan_tujuan }}</td>
                        <td>{{ $row->provinsit_nama }}</td>
                        <td>{{ number_format($row->jarak_mil) }}</td>
                        <td>{{ $row->nama_table }}</td>
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
