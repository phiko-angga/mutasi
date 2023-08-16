@extends('layout._template_pdf',['title' => $title])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($users) !== 0)
                    @foreach($users as $key => $row)
                    <tr>
                        <td>{{ (++$key)}}</td>
                        <td><strong>{{ $row->username }}</strong></td>
                        <td>{{ $row->fullname }}</td>
                        <td>{{ $row->jabatan }}</td>
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
