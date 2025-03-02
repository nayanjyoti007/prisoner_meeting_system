<?php

namespace App\Http\Controllers\Admin\Import;

use App\Http\Controllers\Controller;
use App\Imports\DistrictImport;
use App\Models\District;
use App\Models\DistrictMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class DistrictImportController extends Controller
{
    public function importDistrict()
    {
        return view('admin.import.district-import-form');
    }

    public function importDistrictSubmit(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        try {
            set_time_limit(-1);
            Excel::import(new DistrictImport, $request->file('file'));
            return redirect()->back()->with('success', 'Imported Successfully');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            // Collect all errors
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($errors);
        }
    }



    public static function codeGen()
    {
        $district = DistrictMaster::get();

        foreach ($district as $key => $value) {

            $currentTime = Carbon::now();
            $formattedDate = $currentTime->format('y');

            $formattedDateTime = 'DIS' . '-' . $formattedDate . '-' . $value->id;

            $check = DistrictMaster::where('dist_code', $formattedDateTime)->exists();

            if (!$check) {
                $update = DistrictMaster::where('id', $value->id)->first();
                $update->dist_code = $formattedDateTime;
                $update->save();

                $dist = new District();
                $dist->dist_id = $update->id;
                $dist->password = Hash::make('password');
                $dist->save();
            }
        }

    }
}
