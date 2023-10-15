
@if(sizeof($users) !== 0)
        @foreach($users as $key => $row)
        <tr>
            <td>{{ $users->firstItem() + $key}}</td>
            <td><strong>{{ $row->username }}</strong></td>
            <td>{{ $row->fullname }}</td>
            <td>{{ $row->jabatan }}</td>
            <td>{!! $row->status == 1 ? '<i class="bx bx-check text-info"></i>' : '<i class="bx bx-x text-secondary"></i>' !!}</td>
            <td class="text-center">
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('users/'.$row->id.'/edit')}}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                        <a class="dropdown-item delete_btn"  data-id="{{ $row->id }}" data-name="{{ $row->nomor }}" href="javascript:void(0);"><i class="bx bx-trash me-2"></i> Delete</a>
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
                        <option {{isset($paginate_num) ? ($paginate_num == 25 ? 'selected' : '') : ''}} value="25">25 Records</option>
                        <option {{isset($paginate_num) ? ($paginate_num == 50 ? 'selected' : '') : ''}} value="50">50 Records</option>
                    </select>
                </div>
            </td>
        </tr>
    @else
    <tr>
        <td colspan="8" align="center">
            <h4 class="text-center">No Data Available</h4>
        </td>
    </tr>
    @endif

    @if($users->hasPages())
    <tr>
    <td colspan="8" align="center">
    {!! $users->withQueryString()->links() !!}
    </td>
    </tr>
    @endif