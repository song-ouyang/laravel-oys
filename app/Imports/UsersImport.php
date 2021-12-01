<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{

    public function model(array $row)
    {
        return new Student([
            'id'     => $row[0],
            'name'     => $row[1],
            'phone'   => $row[2],
            'email'    => $row[3],
            'account'    => $row[4],
            'password' => Hash::make($row[5]),
        ]);
    }
}
