<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use Auth;

class LikeController extends Controller
{
    /**
     * تبديل حالة الإعجاب (إضافة/إزالة)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'likeable_id' => 'required|integer',
            'likeable_type' => 'required|in:post,comment'
        ]);

        $likeableId = $request->likeable_id;
        $likeableType = $request->likeable_type;

        // التحقق من وجود العنصر المراد الإعجاب به
        if ($likeableType == 'post') {
            $likeable = Post::findOrFail($likeableId);
            $model = 'App\Models\Post';
        } else {
            $likeable = Comment::findOrFail($likeableId);
            $model = 'App\Models\Comment';
        }

        // التحقق من صلاحية الوصول للمجتمع
        if ($likeableType == 'post') {
            $this->authorize('view', $likeable->community);
        } else {
            $this->authorize('view', $likeable->post->community);
        }

        // البحث عن إعجاب سابق
        $like = Like::where('user_id', Auth::id())
            ->where('likeable_id', $likeableId)
            ->where('likeable_type', $model)
            ->first();

        if ($like) {
            // إزالة الإعجاب
            $like->delete();
            $action = 'unliked';
        } else {
            // إضافة إعجاب جديد
            $like = new Like();
            $like->user_id = Auth::id();
            $like->likeable_id = $likeableId;
            $like->likeable_type = $model;
            $like->save();
            $action = 'liked';
        }

        // حساب عدد الإعجابات الجديد
        $likesCount = Like::where('likeable_id', $likeableId)
            ->where('likeable_type', $model)
            ->count();

        return response()->json([
            'success' => true,
            'action' => $action,
            'likes_count' => $likesCount
        ]);
    }
}
