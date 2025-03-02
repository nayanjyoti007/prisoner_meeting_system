<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePasswordForm()
    {
        return view('visitor.change_password');
    }

    public function changePassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'same:confirm_password'],
        ]);


        $admin = Visitor::where('id', Auth::guard('visitor')->user()->id)->first();

        if (Hash::check($request->input('current_password'), $admin->password)) {
            Visitor::where('id', Auth::guard('visitor')->user()->id)->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
            return redirect()->back()->with('success', 'Password Changed Successfully');
        } else {
            return redirect()->back()->with('error', 'Sorry Current Password Does Not Correct');
        }
    }
}
