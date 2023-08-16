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
                        <th>Kantor PN</th>
                        <th>Ibu Kota Prov.</th>
                        <th>Bandara</th>
                        <th>Pelabuhan</th>
                        <th>Stasiun</th>
                        <th>Terminal</th>
                        <th>Alamat</th>
                        <th>Kode POS</th>
                        <th>Status</th>
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
                        <td class="text-center">{!! $row->kantor == '1' ? '<span style="font-family:zapfdingbats;">4</span>' : '' !!}</td>
                        <td class="text-center">{!! $row->ibukota_prov == '1' ? '<span style="font-family:zapfdingbats;">4</span>' : '' !!}</td>
                        <td class="text-center">{!! $row->bandara == '1' ? '<span style="font-family:zapfdingbats;">4</span>' : '' !!}</td>
                        <td class="text-center">{!! $row->pelabuhan == '1' ? '<span style="font-family:zapfdingbats;">4</span>' : '' !!}</td>
                        <td class="text-center">{!! $row->stasiun == '1' ? '<span style="font-family:zapfdingbats;">4</span>' : '' !!}</td>
                        <td class="text-center">{!! $row->terminal == '1' ? '<span style="font-family:zapfdingbats;">4</span>' : '' !!}</td>`
                        <td>{{ $row->alamat }}</td>
                        <td>{{ $row->kodepos }}</td>
                        <td class="text-center">{!! $row->status == '1' ? '<span style="font-family:zapfdingbats;">4</span>' : '' !!}</td>
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
