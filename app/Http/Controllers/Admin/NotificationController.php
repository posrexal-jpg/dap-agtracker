<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use LogsActivity;
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
        $count = Notification::unread()->count();
        
        Notification::unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        // Log the activity
        if ($count > 0) {
            $this->logActivity(
                'mark_read',
                "Marked {$count} notifications as read"
            );
        }

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
        
        // Log before deleting
        $this->logDelete($notification, "Deleted notification: {$notification->message}");
        
        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted'
        ]);
    }

    /**
        $count = Notification::read()->count();
        
        Notification::read()->delete();

        // Log the activity
        if ($count > 0) {
            $this->logActivity(
                'delete',
                "Cleared {$count} read notifications"
            );
        }
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
