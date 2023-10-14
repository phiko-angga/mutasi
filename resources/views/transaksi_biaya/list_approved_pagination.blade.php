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
            <td>{{ '' }}</td>
            <td>{{ '' }}</td>
            <td>{{ '' }}</td>
            <td>{{ $row->approved_name }}</td>
            <td>{{Carbon\Carbon::parse($row->approved_at)->formatLocalized('%d %B %Y')}}</td>
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