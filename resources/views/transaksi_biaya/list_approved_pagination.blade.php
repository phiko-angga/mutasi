@isset($data)
    @if(sizeof($data) !== 0)
        @foreach($data as $key => $row)
        <tr>
            <td>{{ $data->firstItem() + $key}}</td>
            <td>{{ $row->nomor }}</td>
            <td>{{ $row->pegawai_diperintah }}</td>
            <td>{{ $row->nip }}</td>
            <td>{{ $row->pangkat.' - '.$row->golongan }}</td>
            <td>{{ $row->status_perkawinan }}</td>
            <td>{{ $row->jabatan_instansi }}</td>
            <td>{{ $row->kelompok_jabatan_nama }}</td>
            <td>{{ number_format($row->rampung_jumlah) }}</td>
            <td>{{ $row->approved_name }}</td>
            <td>{{Carbon\Carbon::parse($row->approved_at)->formatLocalized('%d %B %Y')}}</td><td class="text-center">
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item btn-revisi" data-id="{{$row->id}}" href="#"><i class="bx bx-revision me-2"></i> Revisi</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    @else
    <tr>
        <td colspan="12" align="center">
            <h4 class="text-center">No Data Available</h4>
        </td>
    </tr>
    @endif

    @if($data->hasPages())
    <tr>
    <td colspan="12" align="center">
    {!! $data->withQueryString()->links() !!}
    </td>
    </tr>
    @endif
@endisset