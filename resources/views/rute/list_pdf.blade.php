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
                        <th>Nama Kota</th>
                        <th>Bus</th>
                        <th>Kapal Laut / KA</th>
                        <th>Plane</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($data) !== 0)
                    @foreach($data as $key => $row)
                    <tr>
                        <td>{{ (++$key)}}</td>
                        <td>{{ $row->kode }}</td>
                        <td>{{ $row->kota_nama }}</td>
                        <td>{{ number_format($row->bus) }}</td>
                        <td>{{ number_format($row->kapal) }}</td>
                        <td>{{ number_format($row->plane) }}</td>
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
