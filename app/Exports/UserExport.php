<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'username',
            'Nama Lengkap',
            'Jabatan'
        ];
    }

    public function map($user): array
    {
        return [
            $user->username,
            $user->fullname,
            $user->jabatan,
        ];
    }
    
    public function collection()
    {
        $mUser = new User();
        $user = $mUser->get_data($this->request,false);
        return $user;
        
    }
}
