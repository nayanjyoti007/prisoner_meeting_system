<?php

namespace App\Imports;

use App\Exceptions\CenterImportException;
use App\Models\DistrictMaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DistrictImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // dd($row);

        if (!isset($row['district_name'])) {
            throw new CenterImportException("Invalid District Name: " . $row['district_name']);
        }

        if (isset($row['district_name'])) {
            $dist = new DistrictMaster();
            $dist->dist_name = $row['district_name'];
            $dist->save();

            return $dist;
        }
    }

    /**
     * Validate the code (example: can add more checks)
     *
     * @param string $schCode
     * @return bool
     */

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
