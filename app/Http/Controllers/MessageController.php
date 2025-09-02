<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Community;
use Auth;
use Carbon\Carbon;
use Exception;

class MessageController extends Controller
{
    /**
     * إرسال رسالة جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'community_id' => 'required|exists:communities,id',
            'content' => 'required|string'
        ]);

        $community = Community::findOrFail($request->community_id);

        // التحقق من صلاحية الوصول
        $this->authorize('view', $community);

        $message = new Message();
        $message->community_id = $request->community_id;
        $message->user_id = Auth::id();
        $message->content = $request->content;
        $message->is_read = false;
        $message->save();

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الرسالة بنجاح',
            'time' => $message->created_at->format('h:i A')
        ]);
    }

    /**
     * الحصول على الرسائل الجديدة
     */
    public function getNewMessages(Request $request)
    {
        $request->validate([
            'community_id' => 'required|exists:communities,id',
            'last_id' => 'required|integer'
        ]);

        $community = Community::findOrFail($request->community_id);

        // التحقق من صلاحية الوصول
        $this->authorize('view', $community);

        $messages = Message::where('community_id', $request->community_id)
            ->where('id', '>', $request->last_id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        $formattedMessages = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'user_name' => $message->user->user_name,
                'user_image' => $message->user->image
                    ? asset('uploads/' . $message->user->image)
                    : asset('admin/assets/media/users/300_21.jpg'),
                'content' => $message->content,
                'time' => $message->created_at->format('h:i A')
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $formattedMessages
        ]);
    }

    /**
     * تحديث حالة قراءة الرسائل
     */
    public function markAsRead(Request $request)
    {
        try {
            $request->validate([
                'community_id' => 'required|exists:communities,id'
            ]);

            $community = Community::findOrFail($request->community_id);

            // التحقق من صلاحية الوصول
            $this->authorize('view', $community);

            Message::where('community_id', $request->community_id)
                ->where('user_id', '!=', Auth::id())
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة القراءة بنجاح'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث حالة القراءة',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
