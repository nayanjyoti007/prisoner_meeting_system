<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\Jail;
use App\Models\MeetingParticipant;
use App\Models\MeetingRequest;
use App\Models\Prisoner;
use App\Models\Visitor;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendingMeetingRequestsController extends Controller
{
    public function requestlist()
    {
        $data = DB::table('meeting_requests')
            ->join('visitors', 'meeting_requests.visitor_id', '=', 'visitors.id')
            ->join('prisoners', 'meeting_requests.prisoner_id', '=', 'prisoners.id')
            ->join('jails', 'meeting_requests.jail_id', '=', 'jails.id')
            ->select('meeting_requests.*', 'visitors.fullname as visitor_name', 'prisoners.name as prisoner_name', 'jails.name as jail_name')
            ->orderBy('meeting_requests.id', 'desc')
            ->get();

        return view('visitor.meeting_request.list', compact('data'));
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

        return view('visitor.meeting_request.details', compact('meeting', 'participants'));
    }

    public function requestform()
    {
        $visitor_id = Auth::guard('visitor')->id();
        $visitor_data = Visitor::where('id', $visitor_id)->first();
        $jailer = Jail::where('id', $visitor_data->jailer_id)->select('id', 'name')->first();
        $family_members = FamilyMember::where('visitor_id', $visitor_id)->where('kyc_status', 'Approved')->select('id', 'fullname', 'phone')->get();
        $prisoners = Prisoner::where('jail_id', $visitor_data->jailer_id)->where('status', 'Active')->select('id', 'name')->get();
        return view('visitor.meeting_request.form', compact('prisoners', 'visitor_data', 'family_members', 'jailer'));
    }


    public function requestMeeting(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'prisoner_id' => 'required|exists:prisoners,id',
            'jail_id' => 'required|exists:jails,id',
            'meeting_date' => 'required|date|after:today',
            'meeting_time' => 'required',
            'phone' => 'required|numeric|digits:10|regex:/^(\+91[\-\s]?)?[6789]\d{9}$/',
            'group_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'include_visitor' => 'nullable|boolean',
            'confirm' => 'accepted',
            'family_members' => 'nullable|array',
            'family_members.*' => 'exists:family_members,id'
        ]);

        try {
            DB::beginTransaction();

            $jail = Jail::findOrFail($request->jail_id);
            $totalRooms = $jail->total_rooms;

            $bookedMeetings = MeetingRequest::where('jail_id', $request->jail_id)
                ->where('meeting_date', $request->meeting_date)
                ->where('meeting_time', $request->meeting_time)
                ->whereIn('status', ['Approved', 'Pending'])
                ->count();


            $duplicateMeeting = MeetingRequest::where('jail_id', $request->jail_id)
                ->where('meeting_date', $request->meeting_date)
                ->where('meeting_time', $request->meeting_time)
                ->whereIn('status', ['Approved', 'Pending'])
                ->exists();

            if ($duplicateMeeting) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already requested a meeting for this prisoner at the same date and time.'
                ]);
            }

            if ($bookedMeetings >= $totalRooms) {
                return response()->json([
                    'success' => false,
                    'message' => 'No available rooms for this date and time. Please choose a different time.'
                ]);
            }


            if ($request->hasFile('group_image')) {
                $folder = 'upload/group_image/';
                // FileService::delete($data->group_image, $folder);
                $group_image = FileService::save($request->file('group_image'), $folder);
            }



            // Create meeting request
            $meeting = MeetingRequest::create([
                'visitor_id' => $request->visitor_id,
                'prisoner_id' => $request->prisoner_id,
                'jail_id' => $request->jail_id,
                'meeting_date' => $request->meeting_date,
                'meeting_time' => $request->meeting_time,
                'phone' => $request->phone,
                'group_image' => $group_image,
                'status' => 'Pending',
            ]);

            if ($request->include_visitor) {
                MeetingParticipant::create([
                    'meeting_id' => $meeting->id,
                    'visitor_id' => $request->visitor_id,
                    'is_visitor' => true
                ]);
            }

            if (!empty($request->family_members)) {
                foreach ($request->family_members as $family_id) {
                    MeetingParticipant::create([
                        'visitor_id' => $request->visitor_id,
                        'meeting_id' => $meeting->id,
                        'family_id' => $family_id,
                        'is_visitor' => false
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Meeting request submitted.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Meeting Request Failed: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting the request.'
            ], 500);
        }
    }
}
