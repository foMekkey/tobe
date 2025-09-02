<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Auth;
use App\Notifications\CommunityNotification;
use Notification;

class CommentController extends Controller
{
    /**
     * إنشاء تعليق جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $post = Post::findOrFail($request->post_id);

        // التحقق من صلاحية الوصول للمجتمع
        $this->authorize('view', $post->community);

        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;

        if ($request->has('parent_id')) {
            $comment->parent_id = $request->parent_id;
        }

        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة التعليق بنجاح',
            'comment' => $comment
        ]);
    }

    /**
     * تحديث تعليق
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);

        // التحقق من صلاحية التعديل
        $this->authorize('update', $comment);

        $comment->content = $request->content;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث التعليق بنجاح',
            'comment' => $comment
        ]);
    }

    /**
     * حذف تعليق
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // التحقق من صلاحية الحذف
        $this->authorize('delete', $comment);

        // حذف الردود والإعجابات المرتبطة
        $comment->replies()->delete();
        $comment->likes()->delete();

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف التعليق بنجاح'
        ]);
    }
}
