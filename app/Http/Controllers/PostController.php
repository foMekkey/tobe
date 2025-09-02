<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Community;
use Auth;
use Storage;
use App\Notifications\CommunityNotification;
use Notification;

class PostController extends Controller
{
    /**
     * إنشاء منشور جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'community_id' => 'required|exists:communities,id',
            'content' => 'required_without:media|string',
            'type' => 'required|in:text,image,video,audio,file',
            'media' => 'nullable|file|max:20480', // 20MB max
        ]);

        $community = Community::findOrFail($request->community_id);

        // التحقق من صلاحية الوصول
        $this->authorize('view', $community);

        $post = new Post();
        $post->community_id = $request->community_id;
        $post->user_id = Auth::id();
        $post->content = $request->content;
        $post->type = $request->type;

        // معالجة الملفات المرفقة
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('community/posts', 'public');
            $post->media_url = $path;
        }

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء المنشور بنجاح',
            'post' => $post
        ]);
    }

    /**
     * تحديث منشور
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($id);

        // التحقق من صلاحية التعديل
        $this->authorize('update', $post);

        $post->content = $request->content;
        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث المنشور بنجاح',
            'post' => $post
        ]);
    }

    /**
     * حذف منشور
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // التحقق من صلاحية الحذف
        $this->authorize('delete', $post);

        // حذف الملف المرفق إن وجد
        if ($post->media_url) {
            Storage::disk('public')->delete($post->media_url);
        }

        // حذف التعليقات والإعجابات المرتبطة
        $post->comments()->delete();
        $post->likes()->delete();

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المنشور بنجاح'
        ]);
    }

    /**
     * تثبيت/إلغاء تثبيت منشور
     */
    public function togglePin($id)
    {
        $post = Post::findOrFail($id);

        // التحقق من صلاحية التثبيت (للمشرفين فقط)
        $this->authorize('pin', $post);

        $post->is_pinned = !$post->is_pinned;
        $post->save();

        return response()->json([
            'success' => true,
            'message' => $post->is_pinned ? 'تم تثبيت المنشور بنجاح' : 'تم إلغاء تثبيت المنشور بنجاح',
            'is_pinned' => $post->is_pinned
        ]);
    }
}
