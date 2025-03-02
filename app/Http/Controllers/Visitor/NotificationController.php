<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\VisitorNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function notification(){
        $visitor_id = Auth::guard('visitor')->id();
        $notifications = VisitorNotification::whereJsonContains('visitor_id', $visitor_id)->latest()->get();
        return view('visitor.notification.list', compact('notifications'));
    }

    public function notificationRemoveDashboard(Request $request)
    {
        $visitor = Auth::guard('visitor')->user()->id;

        // Fetch the notifications for the logged-in user
        $notifications = VisitorNotification::whereJsonContains('visitor_id', $visitor)->get();

        // Update each notification
        foreach ($notifications as $notification) {
            $notification->show_in_dashboard = 1;
            $notification->save();
        }

        // Return a JSON response
        return response()->json(['success' => true]);
    }

    public function notificationDetails($id){
        $details = VisitorNotification::where('id', $id)->first();
        $details->mark_read = 1;
        $details->save();
        return view('visitor.notification.details', compact('details'));
    }

}
