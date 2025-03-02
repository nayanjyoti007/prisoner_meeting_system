<?php

namespace App\Http\Controllers\Admin\Import;

use App\Http\Controllers\Controller;
use App\Imports\StudentImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentImportController extends Controller
{
    public function importStudent(){
        return view('admin.import.student-import-form');
    }

    public function importStudentSubmit(Request $request)
    {
        // dd($request->all());

        // $request->validate([
        //     'file' => 'required|mimes:xls,xlsx,csv'
        // ]);

        // try {
        //     set_time_limit(-1);
        //     Excel::import(new StudentImport, $request->file('file'));
        //     return redirect()->back()->with('success', 'Students Imported Successfully');
        // } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        //     $failures = $e->failures();
        //     // Collect all errors
        //     $errors = [];
        //     foreach ($failures as $failure) {
        //         $errors[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
        //     }
        //     return redirect()->back()->withErrors($errors);
        // }


        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            set_time_limit(-1);
            Excel::import(new StudentImport, $request->file('file'));
            return back()->with('success', 'Import successful!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            return back()->with('error', implode('<br>', $errors));
        } catch (\Exception $e) {
            return back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }


    }
}
