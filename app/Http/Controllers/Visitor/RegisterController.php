<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class RegisterController extends Controller
{
    public $today_date;
    public $current_time;

    public function __construct()
    {
        $this->today_date = Carbon::now()->setTimezone('Asia/Kolkata')->format('Y-m-d');
        $this->current_time = Carbon::now()->setTimezone('Asia/Kolkata')->format('h:i A');
    }

    public function submitRegister(Request $request)
    {
        $this->validate($request, [
            'jailer_id' => 'required|string|exists:jails,id',
            'fullname' => 'required|string',
            'phone' => 'required|numeric|digits:10|regex:/^(\+91[\-\s]?)?[6789]\d{9}$/|unique:visitors,phone',
            'email' => 'nullable|email|unique:visitors,email',
            'gender' => 'required|string|in:Male,Female,Other',
            'password' => 'required|string|min:6|same:confirm_password',
        ]);

        try {
            DB::beginTransaction();

            $visit = new Visitor();
            $msg = "Visitor Registered Successfully. Please complete KYC!";
            $visit->jailer_id = $request->jailer_id;
            $visit->fullname = $request->fullname;
            $visit->email = $request->email;
            $visit->phone = $request->phone;
            $visit->gender = $request->gender;
            $visit->date = now();
            $visit->password = Hash::make($request->password);
            $visit->save();

            // Auto-login the user after registration
            Auth::guard('visitor')->login($visit);

            DB::commit();

            return response()->json(['success' => true, 'message' => $msg, 'redirect' => route('visitor.dashboard')]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Visitor Registration Failed: " . $e->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration. Please try again later.'
            ]);
        }
    }
}
