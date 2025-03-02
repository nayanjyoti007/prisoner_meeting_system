<?php

namespace App\Imports;

use App\Exceptions\StudentImportException;
use App\Models\Center;
use App\Models\Student;
use App\Models\StudentAcademic;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StudentImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $validator = Validator::make($row->toArray(), $this->rules(), $this->customValidationMessages());

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            $code = str_pad($row['institution_code'], 6, '0', STR_PAD_LEFT);

            $center = Center::where('code', $code)->first();

            if (!$center) {
                throw new StudentImportException("Invalid institution_code: " . $row['institution_code']);
            }


            // Create Student
            $student = Student::create([
                'center_id' => $center->id,
                'dist_code' => $row['dist_code'],
                'dist_name' => $row['dist_name'],
                'student_id' => $row['student_id'],
                'candidate_name' => $row['candidate_name'],
                'fathers_name' => $row['fathers_name'],
                'mothers_name' => $row['mothers_name'],
                'reg_no' => $row['reg_no'],
                'gender' => $gender,
                'category' => $row['category'],
                'mobile_no' => $row['mobile_no'],
                'sch_code' => $code,
                'school_college_name' => $row['school_college_name'],
                'photo' => $row['photo'],
                'signature' => $row['signature'],
                'status' => 1,
                'created_at' => $row['created_at'] ?? now(),
                'updated_at' => $row['updated_at'] ?? now(),
            ]);

            // Create Student Academic
            StudentAcademic::create([
                'student_id' => $student->id,
                'center_id' => $center->id,
                'class' => 1,
                'session_id' => 1,
                'stream' => $row['stream'],
                'subjects' => [
                    'sub1' => $row['sub1'],
                    'sub2' => $row['sub2'],
                    'sub3' => $row['sub3'],
                    'sub4' => $row['sub4'],
                    'sub5' => $row['sub5'],
                    'sub6' => $row['sub6'],
                ],
                'status' => 1,
                'created_at' => $row['created_at'] ?? now(),
                'updated_at' => $row['updated_at'] ?? now(),
            ]);
        }
    }


    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time
    }


    public function rules(): array
    {
        return [
            'sch_code' => 'required|numeric',
            'dist_code' => 'required|numeric',
            'dist_name' => 'required|string|max:200',
            'student_id' => 'required|numeric',
            'candidate_name' => 'required|string|max:200',
            'fathers_name' => 'required|string|max:200',
            'mothers_name' => 'required|string|max:200',
            'reg_no' => 'required|numeric',
            'gender' => 'required|string|in:MALE,FEMALE,OTHER',
            'category' => 'nullable|string|max:50',
            'mobile_no' => [
                'required',
                'numeric',
                'digits:10',
            ],
            'school_college_name' => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'signature' => 'nullable|string|max:255',
            'stream' => 'nullable|string|max:100',
            'sub1' => 'required|string|max:100',
            'sub2' => 'required|string|max:100',
            'sub3' => 'required|string|max:100',
            'sub4' => 'required|string|max:100',
            'sub5' => 'nullable|string|max:100',
            'sub6' => 'nullable|string|max:100',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
        ];
    }


    public function customValidationMessages()
    {
        return [
            'sch_code.required' => 'The school code is required.',
            'dist_code.required' => 'The district code is required.',
            'candidate_name.required' => 'The candidate name is required.',
            'mobile_no.required' => 'The mobile number is required.',
            'mobile_no.unique' => 'This mobile number has already been taken.',
            'gender.required' => 'The gender is required.',
            'sub1.required' => 'Subject 1 is required.',
        ];
    }
}
