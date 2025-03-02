<?php

namespace App\Helper;

use App\Models\Center;
use App\Models\StudentAcademic;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MyHelpers
{
    public static function getSubjectName($cid)
    {
        $data = Center::where('id', $cid)->first();

        $objectsArray = array_map(function ($code) {
            return (object)['code' => $code];
        }, $data->subject_code);


        return response()->json($data->subject_code);
    }
}
