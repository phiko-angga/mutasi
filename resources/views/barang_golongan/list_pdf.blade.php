@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Golongan</th>
                        <th>Bujangan</th>
                        <th>Keluarga</th>
                        <th>Anak 1</th>
                        <th>Anak 2</th>
                        <th>Anak 3+</th>
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
                        <td>{{ $row->golongan }}</td>
                        <td>{{ number_format($row->bujangan) }}</td>
                        <td>{{ number_format($row->keluarga) }}</td>
                        <td>{{ number_format($row->anak1) }}</td>
                        <td>{{ number_format($row->anak2) }}</td>
                        <td>{{ number_format($row->anak3) }}</td>
                        <td>{{ $row->created_name }}</td>
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->updated_name }}</td>
                        <td>{{ $row->updated_at }}</td>
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
