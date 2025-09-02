<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Carbon\Carbon;
use Auth;

class NotificationController extends Controller
{
    /**
     * تعليم إشعار معين كمقروء
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        // التحقق من أن الإشعار ينتمي للمستخدم الحالي
        if ($notification->user_id == Auth::id()) {
            $notification->read_at = Carbon::now();
            $notification->save();

            // إذا كان الإشعار يحتوي على رابط، قم بإرجاع الرابط للتوجيه
            if ($notification->type == 2) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => $notification->getLink()
                ]);
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    /**
     * تعليم جميع إشعارات المستخدم كمقروءة
     */
    public function markAllAsRead()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->get();

        foreach ($notifications as $notification) {
            $notification->read_at = Carbon::now();
            $notification->save();
        }

        return response()->json(['success' => true]);
    }
}
