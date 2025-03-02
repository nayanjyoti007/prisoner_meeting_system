<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Center;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePasswordForm()
    {
        return view('admin.change_password');
    }

    public function changePassword(Request $request)
    {

        // $userRoles = Auth::user()->getRoleNames();
        // dd($userRoles->isNotEmpty() ? $userRoles->first() : 'admin');


        // dd(Auth::user()->hasAnyPermission('change.form.two'));


        $this->validate($request, [
            // 'manager_name' => [
            //     Auth::user()->hasAnyPermission(['change.form.two']) ? 'required' : 'nullable',
            //     'string',
            // ],
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'same:confirm_password'],
        ]);


        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();

        if (Hash::check($request->input('current_password'), $admin->password)) {
            Admin::where('id', Auth::guard('admin')->user()->id)->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
            return redirect()->back()->with('success', 'Password Changed Successfully');
        } else {
            return redirect()->back()->with('error', 'Sorry Current Password Does Not Correct');
        }
    }

    public function changeSchoolPasswordForm()
    {
        return view('admin.center.change_password');
    }

    public function changeSchoolPassword(Request $request)
    {

        $this->validate($request, [
            'code' => ['required'],
            'new_password' => ['required', 'string', 'min:6', 'same:confirm_password'],
        ]);


        Center::where('code', $request->code)->update(['password' => Hash::make($request->input('new_password'))]);
        return redirect()->back()->with('success', 'Password Changed Successfully');

    }
}
