<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Jail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public $today_date;
    public $current_time;
    public $current_datetime;


    public function __construct()
    {
        $this->today_date = Carbon::now()
            ->setTimezone('Asia/Kolkata')
            ->format('Y-m-d');
        $this->current_time = Carbon::now()
            ->setTimezone('Asia/Kolkata')
            ->format('h:i A');
        $this->current_datetime = Carbon::now()
            ->setTimezone('Asia/Kolkata')
            ->format('h:i A d F Y');
    }

    public function index()
    {
        return redirect()->route('login');
    }

    public function login()
    {
        if (Auth::guard('visitor')->check()) {
            return redirect()->route('visitor.dashboard');
        }

        return view('visitor.login');
    }

    public function loginSubmit(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric|digits:10|exists:visitors,phone',
            'password' => 'required|min:6',
        ]);

        $userCredential = $request->only('phone', 'password');

        if (Auth::guard('visitor')->attempt($userCredential)) {
            return redirect()->route('visitor.dashboard');
        } else {
            return back()->with('error', 'Username & Password Incorrect');
        }
    }

    public function logout()
    {
        Auth::guard('visitor')->logout();
        return redirect()->route('login');
    }

    public function register()
    {
        if (Auth::guard('visitor')->check()) {
            return redirect()->route('visitor.dashboard');
        }

        $jails = Jail::where('status', 1)->select('id', 'name')->get();
        return view('visitor.register', compact('jails'));
    }
}
