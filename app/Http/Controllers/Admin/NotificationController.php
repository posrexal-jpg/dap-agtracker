<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get all notifications for admin
     */
    public function index()
    {
        $notifications = Notification::with(['location', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = Notification::unread()->count();

        return view('admin.notifications', compact('notifications', 'unreadCount'));
    }

    /**
     * Get unread notification count (AJAX)
     */
    public function getUnreadCount()
    {
        $count = Notification::unread()->count();
        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications (AJAX)
     */
    public function getRecent()
    {
        $notifications = Notification::with(['location', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Notification::unread()->count()
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted'
        ]);
    }

    /**
     * Delete all read notifications
     */
    public function clearRead()
    {
        Notification::read()->delete();

        return response()->json([
            'success' => true,
            'message' => 'All read notifications cleared'
        ]);
    }
}
