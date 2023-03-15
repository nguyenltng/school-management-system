<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    use Exportable;
    private $stage;

    public function __construct(int $stage)
    {
        $this->stage = $stage;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            'name' => $row['name'],
            'nick_name' =>  $row['nick_name'],
            'dob' =>  $row['dob'],
            'gender' =>  $row['gender'],
            'source' =>  $row['source'],
            'compaign' => $row['compaign'],
            'nationality' =>  $row['nationality'],
            'email' =>  $row['email'],
            'phone_no' =>  $row['phone_no'],
            'note' =>  $row['note'],
            'father_name' =>  $row['father_name'],
            'father_phone_no' =>  $row['father_phone_no'],
            'mother_name' =>  $row['mother_name'],
            'mother_phone_no' =>  $row['mother_phone_no'],
            'guardian' =>  $row['guardian'],
            'guardian_phone_no' => $row['guardian_phone_no'],
            'present_address' =>  $row['present_address'],
            'permanent_address' => $row['permanent_address'],
            'status' =>  $row['status'],
            'stage' => $this->stage
        ]);
    }

    public function headingRow(): int
    {
        return 2;
    }
}
