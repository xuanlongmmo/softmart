<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class exportController extends Controller implements FromCollection, WithHeadings
{
    use Exportable;
    public function collection()
    {
        $users = \App\User::all();
        foreach ($users as $row) {
            $user[] = array(
                '0' => $row->id,
                '1' => $row->username,
                '2' => $row->fullname,
                '3' => $row->email,
                '4' => $row->phone,
                '5' => $row->group_user->group_name
            );
        }
        return (collect($user));
    }
    public function headings(): array
    {
        return [
            'Id',
            'Username',
            'Fullname',
            'Email',
            'Phone',
            'Group'
        ];
    }
    public function export(){
        return Excel::download(new exportController(), 'user.xlsx');
   }
}
