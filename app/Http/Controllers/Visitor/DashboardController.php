<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\VisitorNotification;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
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

    public function dashboard()
    {
        $visitor_id = Auth::guard('visitor')->id();
        $visitorData = Visitor::where('id', $visitor_id)->first();
        $notifications = VisitorNotification::where('visitor_id', $visitor_id)->where('show_in_dashboard', 0)->where('mark_read', 0)->get();

        $approved_qr = DB::table('meeting_requests')
            ->select('meeting_requests.*')
            ->orderBy('meeting_requests.id', 'desc')
            ->where('meeting_requests.visitor_id', $visitor_id)
            ->where('meeting_requests.status', 'Approved')
            ->latest()->first();

        return view('visitor.dashboard', compact('visitorData', 'notifications', 'approved_qr'));
    }

    public function kycUpdate(Request $request)
    {

        $this->validate($request, [
            'id' => 'required|numeric|exists:visitors,id',
            'aadhar_number' => 'required|string|size:12|unique:visitors,aadhar_number,' . $request->post('id'),
            'voter_id' => 'required|string|min:10|max:20|unique:visitors,voter_id,' . $request->post('id'),
            'aadhar_proof' => 'required_without:id|file|mimes:jpg,png,pdf|max:2048',
            'voter_proof' => 'required_without:id|file|mimes:jpg,png,pdf|max:2048'
        ]);

        try {
            // Begin transaction
            DB::beginTransaction();

            $visit = Visitor::findOrFail($request->id);
            $msg = "KYC Submitted, Waiting for Approval.";
            $visit->aadhar_number = $request->aadhar_number;
            $visit->voter_id = $request->voter_id;

            $folder = 'upload/visitor/kyc/';

            if ($request->hasFile('aadhar_proof')) {
                FileService::delete($visit->aadhar_proof, $folder);
                $visit->aadhar_proof = FileService::save($request->file('aadhar_proof'), $folder);
            }

            if ($request->hasFile('voter_proof')) {
                FileService::delete($visit->voter_proof, $folder);
                $visit->voter_proof = FileService::save($request->file('voter_proof'), $folder);
            }

            // Update KYC status to "Update KYC"
            $visit->kyc_status = "Update KYC";
            $visit->kyc_update_date = $this->today_date;
            $visit->save();

            // Commit the transaction
            DB::commit();

            return response()->json(['success' => true, 'message' => $msg]);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            // Log the error to laravel.log
            Log::error("Visitor KYC Update Failed: " . $e->getMessage(), [
                'request_data' => $request->except(['aadhar_proof', 'voter_proof']), // Avoid logging sensitive files
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during KYC update. Please try again later.'
            ], 500);
        }
    }



    public function notificationDetails($id)
    {
        $data = VisitorNotification::where('id', $id)->first();
        return view('user.notification.details_model', compact('data'));
    }

    public function notificationMarkRead(Request $request)
    {
        try {
            $data = VisitorNotification::findOrFail($request->id);
            $data->mark_read = 1;
            $data->save();
            return response()->json(['success' => true, 'message' => 'Delete Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function notificationDelete(Request $request)
    {
        try {
            $data = VisitorNotification::findOrFail($request->id);
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Delete Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
