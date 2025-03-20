<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\Visitor;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FamilyMembersController extends Controller
{
    public $today_date;
    public $current_time;

    public function __construct()
    {
        $this->today_date = Carbon::now()->setTimezone('Asia/Kolkata')->format('Y-m-d');
        $this->current_time = Carbon::now()->setTimezone('Asia/Kolkata')->format('h:i A');
    }


    public function list()
    {
        $visitor_id = Auth::guard('visitor')->user()->id;
        $members = FamilyMember::where('visitor_id', $visitor_id)->latest()->get();
        return view('visitor.members.list', compact('members'));
    }

    public function form($id = null)
    {
        $visitor_id = Auth::guard('visitor')->user()->id;

        if ($id) {
            $id = hashid()->decode($id);
            $data = FamilyMember::findOrFail($id);
            return view('visitor.members.form', compact('data', 'visitor_id'));
        } else {
            return view('visitor.members.form', compact('visitor_id'));
        }
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'id' => 'nullable|numeric|exists:family_members,id',
            'visitor_id' => 'required|numeric|exists:visitors,id',
            'fullname' => 'required|string|max:50',
            'phone' => 'required|numeric|digits:10|regex:/^(\+91[\-\s]?)?[6789]\d{9}$/|unique:family_members,phone,' . $request->post('id'),
            'email' => 'nullable|email|unique:family_members,email,' . $request->post('id'),
            'gender' => 'required|string|in:Male,Female,Other',
            'aadhar_number' => 'required|string|size:12|unique:family_members,aadhar_number,' . $request->post('id'),
            'voter_id' => 'required|string|min:10|max:20|unique:family_members,voter_id,' . $request->post('id'),
            'aadhar_proof' => 'required_without:id|file|mimes:jpg,png,pdf|max:2048',
            'voter_proof' => 'required_without:id|file|mimes:jpg,png,pdf|max:2048',
            'profile_image' => 'required_without:id'
        ]);

        $id = $request->id;

        if ($id) {
            $data = FamilyMember::findOrFail($id);
            $msg = "Member KYC Submitted, Waiting for Approval !!";
        } else {
            $data = new FamilyMember();
            $msg = "Member KYC Submitted, Waiting for Approval !!";
        }

        $data->visitor_id = $request->visitor_id;
        $data->fullname = $request->fullname;
        $data->phone = $request->phone;
        $data->gender = $request->gender;
        $data->aadhar_number = $request->aadhar_number;
        $data->voter_id = $request->voter_id;
        $data->kyc_status = 'Pending';
        $data->reason_kyc_rejected = null;

        $folder = 'upload/members/kyc/';

        if ($request->hasFile('aadhar_proof')) {
            FileService::delete($data->aadhar_proof, $folder);
            $data->aadhar_proof = FileService::save($request->file('aadhar_proof'), $folder);
        }

        if ($request->hasFile('voter_proof')) {
            FileService::delete($data->voter_proof, $folder);
            $data->voter_proof = FileService::save($request->file('voter_proof'), $folder);
        }


        if ($request->profile_image) {
            $image = $request->profile_image;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.png';
            \File::put(storage_path('app/public/backend_images/upload/members/kyc/' . $imageName), base64_decode($image));
        }

        $data->registered_at = $this->today_date;
        $data->profile_proof = $imageName;
        $data->save();
        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function status($id)
    {
        $data = FamilyMember::findOrFail($id);
        $data->status = $data->status == 1 ? 2 : 1;
        $data->save();
        return back()->with('success', 'Status Update Successfully !!');
    }

    public function delete(Request $request)
    {
        try {
            $data = FamilyMember::findOrFail($request->id);
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Delete Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
