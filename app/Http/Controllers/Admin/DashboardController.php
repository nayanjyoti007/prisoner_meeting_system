<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\MeetingRequest;
use App\Models\Visitor;
use App\Models\VisitorNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;





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
        $pending_members = FamilyMember::where('kyc_status', 'Pending')->count();
        $pending_account = Visitor::where('kyc_status', 'Update KYC')->count();
        $pending_request = MeetingRequest::count();
        return view('admin.dashboard', compact('pending_members', 'pending_account', 'pending_request'));
    }

    public function kycVerification()
    {
        $kyc_pending = Visitor::where('kyc_status', 'Update KYC')->select('id', 'fullname', 'phone', 'kyc_update_date', 'kyc_status')->get();
        return view('admin.visitor_account_kyc_verification.list', compact('kyc_pending'));
    }

    public function kycVerificationDetails($id)
    {
        $details = Visitor::where('id', $id)->first();
        return view('admin.visitor_account_kyc_verification.details', compact('details'));
    }

    public function kycVerificationStatusUpdate(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric', 'exists:visitors,id'],
            'kyc_status' => ['required', Rule::in(['Approved', 'Rejected'])],
            'reason_kyc_rejected' => ['required_if:kyc_status,Rejected', 'nullable', 'string', 'max:255'],
        ], [
            'id.required' => 'Visitor ID is required.',
            'id.exists' => 'The selected visitor does not exist.',
            'kyc_status.required' => 'Please select the KYC status.',
            'reason_kyc_rejected.required_if' => 'Please provide a reason for rejection.',
        ]);

        try {
            DB::beginTransaction();

            $visitor = Visitor::findOrFail($request->id);
            $msg = "Visitor KYC Status Notification !";

            $visitor->update([
                'kyc_status' => $request->kyc_status,
                'reason_kyc_rejected' => $request->kyc_status === 'Rejected' ? $request->reason_kyc_rejected : null
            ]);


            VisitorNotification::create([
                'visitor_id' => $request->id,
                'title' => $msg,
                'description' => $request->kyc_status === 'Rejected' ? $request->reason_kyc_rejected : null,
                'time_date' => $this->current_datetime,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => $msg]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Visitor KYC Status Notification Update Failed: " . $e->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating KYC. Please try again later.'
            ], 500);
        }
    }


    public function memberkycVerification()
    {
        $kyc_pending = FamilyMember::where('kyc_status', 'Pending')->select('id', 'visitor_id', 'fullname', 'phone', 'registered_at')->get();
        return view('admin.member_kyc_verification.list', compact('kyc_pending'));
    }

    public function memberkycVerificationDetails($id)
    {
        $details = FamilyMember::where('id', $id)->first();
        return view('admin.member_kyc_verification.details', compact('details'));
    }

    public function memberkycVerificationStatusUpdate(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric', 'exists:family_members,id'],
            'visitor_id' => ['required', 'numeric', 'exists:visitors,id'],
            'kyc_status' => ['required', Rule::in(['Approved', 'Rejected'])],
            'reason_kyc_rejected' => ['required_if:kyc_status,Rejected', 'nullable', 'string', 'max:255'],
        ], [
            'kyc_status.required' => 'Please select the KYC status.',
            'reason_kyc_rejected.required_if' => 'Please provide a reason for rejection.',
        ]);

        try {
            DB::beginTransaction();

            $member = FamilyMember::findOrFail($request->id);
            $msg = "Member KYC Status Updated Successfully!";

            $member->update([
                'kyc_status' => $request->kyc_status,
                'reason_kyc_rejected' => $request->kyc_status === 'Rejected' ? $request->reason_kyc_rejected : null
            ]);


            VisitorNotification::create([
                'visitor_id' => $request->visitor_id,
                'title' => $msg,
                'time_date' => $this->current_datetime,
                'description' => $request->kyc_status === 'Rejected' ? $request->reason_kyc_rejected : null
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => $msg]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("KYC Status Update Failed: " . $e->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating KYC. Please try again later.'
            ], 500);
        }
    }


    public function request()
    {
        $kyc_pending = DB::table('meeting_requests')
            ->join('visitors', 'meeting_requests.visitor_id', '=', 'visitors.id')
            ->join('prisoners', 'meeting_requests.prisoner_id', '=', 'prisoners.id')
            ->join('jails', 'meeting_requests.jail_id', '=', 'jails.id')
            ->select('meeting_requests.*', 'visitors.fullname as visitor_name', 'prisoners.name as prisoner_name', 'jails.name as jail_name')
            ->orderBy('meeting_requests.id', 'desc')
            ->get();
        return view('admin.pending_meeting_request.list', compact('kyc_pending'));
    }

    public function requestDetails($id)
    {
        $meeting = DB::table('meeting_requests')
            ->join('visitors', 'meeting_requests.visitor_id', '=', 'visitors.id')
            ->join('prisoners', 'meeting_requests.prisoner_id', '=', 'prisoners.id')
            ->join('jails', 'meeting_requests.jail_id', '=', 'jails.id')
            ->select(
                'meeting_requests.id as meeting_id',
                'meeting_requests.meeting_date',
                'meeting_requests.meeting_time',
                'meeting_requests.status',
                'meeting_requests.qr_code',
                'visitors.fullname as visitor_name',
                'prisoners.name as prisoner_name',
                'jails.name as jail_name'
            )
            ->where('meeting_requests.id', $id)
            ->first();

        // dd($meeting);

        $participants = DB::table('meeting_participants')
            ->leftJoin('visitors', 'meeting_participants.visitor_id', '=', 'visitors.id') // If the visitor is attending
            ->leftJoin('family_members', 'meeting_participants.family_id', '=', 'family_members.id') // If a family member is attending
            ->select(
                'meeting_participants.is_visitor',
                DB::raw("IF(meeting_participants.is_visitor = 1, visitors.fullname, family_members.fullname) as participant_name")
            )
            ->where('meeting_participants.meeting_id', $id)
            ->get();

        // dd($participants);

        return view('admin.pending_meeting_request.details', compact('meeting', 'participants'));
    }

    public function requestStatusUpdateModel($id)
    {

        $meeting = DB::table('meeting_requests')
            ->select(
                'meeting_requests.id as meeting_id',
                'meeting_requests.visitor_id as visitor_id',
                'meeting_requests.meeting_date',
                'meeting_requests.meeting_time',
                'meeting_requests.status',
            )
            ->where('meeting_requests.id', $id)
            ->first();

        return view('admin.pending_meeting_request.status_model', compact('meeting'));
    }

    public function requestStatusUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:meeting_requests,id',
            'meeting_status' => 'required|in:Approved,Rejected,Completed',
            'rejected_reason' => 'required_if:meeting_status,Rejected|string|max:500|nullable'
        ]);

        try {
            DB::beginTransaction(); // Start transaction

            $meeting = MeetingRequest::findOrFail($request->id);

            if ($meeting->status !== 'Pending' && $request->meeting_status === 'Approved') {
                return response()->json(['success' => false, 'message' => 'This meeting request is already processed.']);
            }

            if ($meeting->status !== 'Approved' && $request->meeting_status === 'Completed') {
                return response()->json(['success' => false, 'message' => 'This meeting is not approved yet.']);
            }

            // ✅ Prepare Update Data
            $updateData = ['status' => $request->meeting_status];

            if ($request->meeting_status === 'Approved') {
                $updateData['approved_at'] = now();
                $updateData['rejected_at'] = null;
                $updateData['rejected_reason'] = null;

                // ✅ Simple & Readable QR Code Text (Using Base64 to Avoid Encoding Issues)
                $qrCodeData = json_encode([
                    'Meeting ID' => $meeting->id,
                    'Visitor' => $meeting->visitor->fullname,
                    'Prisoner' => $meeting->prisoner->name,
                    'Jail' => $meeting->jail->name,
                    'Date' => $meeting->meeting_date,
                    'Time' => $meeting->meeting_time,
                    'Status' => 'Approved',
                    'URL' => url("scanner-update/" . encrypt($meeting->id)) // 🔹 Encrypted ID in URL
                ]);

                // dd($qrCodeData);
                $encodedQrData = base64_encode($qrCodeData);



                // ✅ Generate & Store QR Code
                $qrCodePath = "qrcodes/meeting_{$meeting->id}.png";
                Storage::disk('public')->put(
                    $qrCodePath,
                    QrCode::format('png')->size(300)->encoding('UTF-8')->generate($encodedQrData)
                );

                // ✅ Store QR Code Path in Database
                $updateData['qr_code'] = $qrCodePath;
            } elseif ($request->meeting_status === 'Rejected') {
                $updateData['rejected_at'] = now();
                $updateData['rejected_reason'] = $request->rejected_reason;
            } elseif ($request->meeting_status === 'Completed') {
                $updateData['completed_at'] = now();
                $updateData['timeout_at'] = now();
            }

            // ✅ Update Meeting Request
            $meeting->update($updateData);

            // ✅ Create Notification for Visitor
            VisitorNotification::create([
                'visitor_id' => $meeting->visitor_id,
                'title' => "Meeting status updated to {$request->meeting_status} successfully!",
                'time_date' => now(),
                'description' => $request->meeting_status === 'Rejected' ? $request->rejected_reason : null
            ]);

            DB::commit(); // Commit transaction

            return response()->json([
                'success' => true,
                'message' => "Meeting status updated to {$request->meeting_status} successfully!"
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction if an error occurs

            Log::error("Meeting Status Update Failed: " . $e->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the meeting status. Please try again later.'
            ], 500);
        }
    }

    // public function approved()
    // {
    //     $kyc_pending = DB::table('meeting_requests')
    //         ->join('visitors', 'meeting_requests.visitor_id', '=', 'visitors.id')
    //         ->join('prisoners', 'meeting_requests.prisoner_id', '=', 'prisoners.id')
    //         ->join('jails', 'meeting_requests.jail_id', '=', 'jails.id')
    //         ->select('meeting_requests.*', 'visitors.fullname as visitor_name', 'prisoners.name as prisoner_name', 'jails.name as jail_name')
    //         ->orderBy('meeting_requests.id', 'desc')
    //         ->get();
    //     return view('admin.pending_meeting_request.list', compact('kyc_pending'));
    // }

    public function scanner()
    {
        return view('admin.scanner');
    }

    public function scannerUpdate(Request $request)
    {
        Log::info('Student ID', [$request->all()]);

        $request->validate([
            'qr_code_data' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            // ✅ Decode QR Data (Base64 Decoding)
            $decodedData = json_decode(base64_decode($request->qr_code_data), true);

            Log::info('Student ID', [$decodedData]);

            if (!$decodedData || !isset($decodedData['Meeting ID'])) {
                return response()->json(['success' => false, 'message' => 'Invalid QR Code.'], 400);
            }

            // ✅ Get Meeting
            $meeting = MeetingRequest::where('id', $decodedData['Meeting ID'])->firstOrFail();

            if ($meeting->status !== 'Approved') {
                return response()->json(['success' => false, 'message' => 'Meeting is not approved.'], 400);
            }

            $currentTime = Carbon::now();

            // ✅ Update Attendance in MeetingRequest Table
            if ($meeting->present_status === 'Pending') {
                // First Scan → Mark Present & Set `in_time`
                $meeting->update([
                    'present_status' => 'Present',
                    'in_time' => $currentTime
                ]);

                $message = '✅ Visitor checked in successfully!';
            } elseif ($meeting->present_status === 'Present' && is_null($meeting->out_time)) {
                // Second Scan → Set `out_time`
                $meeting->update([
                    'out_time' => $currentTime
                ]);

                $message = '✅ Visitor checked out successfully!';
            } else {
                $message = '⚠️ Visitor already checked out!';
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'meeting_id' => $meeting->id,
                'present_status' => $meeting->present_status,
                'in_time' => $meeting->in_time,
                'out_time' => $meeting->out_time
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("QR Code Scan Failed: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating attendance.'
            ], 500);
        }
    }
}
