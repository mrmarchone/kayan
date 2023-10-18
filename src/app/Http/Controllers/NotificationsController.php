<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view notifications')->only(['index', 'show']);
        $this->middleware('permission:delete notifications')->only(['delete']);
    }

    public function index()
    {
        $notifications = auth()->user()->notifications;
        return view('notifications.index', compact('notifications'));
    }

    public function show($notification)
    {
        $notification = auth()->user()->notifications()->findOrFail($notification);
        $notification->markAsRead();
        return view('notifications.show', compact('notification'));
    }

    public function delete($notification)
    {
        $notification = auth()->user()->notifications()->findOrFail($notification);
        $notification->delete();
        return redirect()->back()->with(['success' => 'Deleted Successfully']);
    }
}
