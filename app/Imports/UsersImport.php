<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'kode_csdm' => $row['kode_csdm'],
            'name'     => $row['name'],
            'email'    => $row['email'], 
            'no_hp'    => '0'.$row['no_hp'], 
            'password' => Hash::make($row['password']),
            'id_role'    => $row['id_role'], 

        ]);
    }

    // public function rules(): array
    // {
    //     return [
    //         'kode_csdm' => 'unique:users,kode_csdm', // Table name, field in your db
    //     ];
    // }

    // public function customValidationMessages()
    // {
    //     return [
    //         'kode_csdm.unique' => 'Terdapat duplikasi data, mohon cek kembali',
    //     ];
    // }
}
