<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            'name'     => $row['Name'] ?? '',
            'nick_name'    => $row['Nick_Name'] ?? '',
            'dob'     => $row['DoB'] ?? '',
            'email' => $row['Email'] ?? '',
            'phone_no'     => $row['Phone_No'] ?? '',
            'gender'     => $row['Gender'] ?? '',
            'nationality'     => $row['Nationality'] ?? '',
            'compaign'     => $row['Compaign'] ?? '',
            'source'     => $row['Source'] ?? '',
            'father_name'     => $row['Father_Name'] ?? '',
            'father_phone_no'     => $row['Father_Phone_No'] ?? '',
            'mother_name'     => $row['Mother_Name'] ?? '',
            'mother_phone_name'     => $row['Mother_Phone_Name'] ?? '',
            'guardian'     => $row['Guardian'] ?? '',
            'guardian_phone_no'     => $row['Guardian_Phone_No'] ?? '',
            'present_address'     => $row['Present_Address'] ?? '',
            'permanent_address'     => $row['Permanent_Address'] ?? '',
            'status'     => $row['Status'] ?? '',
            'stage'     => $row['Stage'] ?? '',
        ]);
    }
}
