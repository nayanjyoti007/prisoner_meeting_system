<?php

namespace App\Http\Controllers\Admin\Import;

use App\Http\Controllers\Controller;
use App\Imports\CenterImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CenterImportController extends Controller
{
    public function importCenter(){
        return view('admin.import.center-import-form');
    }

    public function importCenterSubmit(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        try {
            set_time_limit(-1);
            Excel::import(new CenterImport, $request->file('file'));
            return redirect()->back()->with('success', 'Center Imported Successfully');
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
}
