
@if(sizeof($data) !== 0)
        @foreach($data as $key => $row)
        <tr>
            <td>{{ $data->firstItem() + $key}}</td>
            <td><strong>{{ $row->kode }}</strong></td>
            <td>{{ $row->nama }}</td>
            <td>{!! $row->jawamadura == 1 ? '<i class="bx bx-check text-info"></i>' : '<i class="bx bx-x text-secondary"></i>' !!}</td>
            <td>{!! $row->status == 1 ? '<i class="bx bx-check text-info"></i>' : '<i class="bx bx-x text-secondary"></i>' !!}</td>
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
                        <a class="dropdown-item" href="{{url('provinsi/'.$row->id.'/edit')}}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                        <a class="dropdown-item delete_btn"  data-id="{{ $row->id }}" data-name="{{ $row->nama }}" href="javascript:void(0);"><i class="bx bx-trash me-2"></i> Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    @else
    <tr>
        <td colspan="9" align="center">
            <h4 class="text-center">No Data Available</h4>
        </td>
    </tr>
    @endif

    @if($data->hasPages())
    <tr>
    <td colspan="9" align="center">
    {!! $data->withQueryString()->links() !!}
    </td>
    </tr>
    @endif