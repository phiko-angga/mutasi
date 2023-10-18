
@if(sizeof($data) !== 0)
        @foreach($data as $key => $row)
        <tr>
            <td>{{ $data->firstItem() + $key}}</td>
            <td>{{ number_format($row->biaya_darat) }}</td>
            <td>{{ number_format($row->biaya_laut) }}</td>
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
                        <a class="dropdown-item" href="{{url('biaya-transport/'.$row->id.'/edit')}}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                        <a class="dropdown-item delete_btn"  data-id="{{ $row->id }}" data-name="" href="javascript:void(0);"><i class="bx bx-trash me-2"></i> Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="9">
                <div class=" me-3">
                    <small class="text-light fw-semibold">Show records per page</small>
                    <select style="width:120px" class="form-select form-select-sm" name="show-per-page" id="show-per-page">
                        <option {{isset($paginate_num) ? ($paginate_num == 10 ? 'selected' : '') : 'selected'}} value="10">10 Records</option>
                        <option {{isset($paginate_num) ? ($paginate_num == 30 ? 'selected' : '') : ''}} value="30">30 Records</option>
                        <option {{isset($paginate_num) ? ($paginate_num == 50 ? 'selected' : '') : ''}} value="50">50 Records</option>
                        <option {{isset($paginate_num) ? ($paginate_num == 100 ? 'selected' : '') : ''}} value="100">100 Records</option>
                    </select>
                </div>
            </td>
        </tr>
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