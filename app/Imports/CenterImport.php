<?php

namespace App\Imports;

use App\Exceptions\CenterImportException;
use App\Models\Center;
use App\Models\District;
use App\Models\DistrictMaster;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CenterImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (!isset($row['institution_code'])) {
                throw new CenterImportException("Invalid District Name: " . $row['institution_code']);
            }

           $code =  str_pad($row['institution_code'], 6, '0', STR_PAD_LEFT);

            $checkData = Center::where('code', $code)->first();

            $subject = $row['subject_code'];

            if ($checkData) {
                $total_candidate = $row['total_candidate'] + $checkData->total_candidate;
                $dist = Center::find($checkData->id);
                $dist->subject_code = array_merge($checkData->subject_code,[$subject]);
                $dist->total_candidate = $total_candidate;
            } else {
                $dist = new Center();
                $dist->code = $code;
                $dist->name = $row['institutin_name'];
                $dist->dist_id = $row['dist_code'];
                $dist->subject_code = [$subject];
                $dist->total_candidate = $row['total_candidate'];
            }

            $dist->save();
        }
    }


    private function isValidSchCode($district_name)
    {
        return !empty($district_name) && is_string($district_name);
    }



    public function rules(): array
    {
        return [
            'district_name' => 'required|string|max:200',
        ];
    }

}
