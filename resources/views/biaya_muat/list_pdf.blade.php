@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Biaya Darat</th>
                        <th>Biaya Laut</th>
                        <th>Jawa Madura</th>
                        <th>Nama pembuat</th>
                        <th>Tanggal dibuat</th>
                        <th>Nama pengubah</th>
                        <th>Tanggal diubah</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($data) !== 0)
                    @foreach($data as $key => $row)
                    <tr>
                        <td>{{ (++$key)}}</td>
                        <td>{{ number_format($row->biaya_darat) }}</td>
                        <td>{{ number_format($row->biaya_laut) }}</td>
                        <td class="text-center">{!! $row->jawamadura == '1' ? '<span style="font-family:zapfdingbats;">4</span>' : '' !!}</td>
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->created_name }}</td>
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
