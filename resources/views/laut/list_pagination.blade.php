
@if(sizeof($data) !== 0)
        @foreach($data as $key => $row)
        <tr>
            <td>{{ $data->firstItem() + $key}}</td>
            <td>{{ $row->provinsia_nama }}</td>
            <td>{{ $row->kotaa_nama }}</td>
            <td>{{ $row->provinsit_nama }}</td>
            <td>{{ $row->kotat_nama }}</td>
            <td>{{ number_format($row->jarak_mil) }}</td>
            <td>{{ $row->nama_table }}</td>
            <td>{{ $row->created_at }}</td>
            <td>{{ $row->created_name }}</td>
            <td>{{ $row->updated_at }}</td>
            <td>{{ $row->updated_name }}</td>
            <td class="text-center">
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('laut/'.$row->id.'/edit')}}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                        <a class="dropdown-item delete_btn"  data-id="{{ $row->id }}" data-name="{{ $row->nama }}" href="javascript:void(0);"><i class="bx bx-trash me-2"></i> Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    @else
    <tr>
        <td colspan="10" align="center">
            <h4 class="text-center">No Data Available</h4>
        </td>
    </tr>
    @endif

    @if($data->hasPages())
    <tr>
    <td colspan="10" align="center">
    {!! $data->withQueryString()->links() !!}
    </td>
    </tr>
    @endif