@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kota Asal</th>
                        <th>Provinsi Asal</th>
                        <th>Kota Tujuan</th>
                        <th>Provinsi Tujuan</th>
                        <th>harga (Rp)</th>
                        <th>Tanggal diubah</th>
                        <th>Nama pengubah</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($data) !== 0)
                    @foreach($data as $key => $row)
                    <tr>
                        <td>{{ (++$key)}}</td>
                        <td>{{ $row->kotaa_nama }}</td>
                        <td>{{ $row->provinsia_nama }}</td>
                        <td>{{ $row->kotat_nama }}</td>
                        <td>{{ $row->provinsit_nama }}</td>
                        <td>{{ number_format($row->harga_tiket) }}</td>
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
