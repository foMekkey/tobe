<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Community;
use App\Post;
use App\Comment;
use App\Message;
use App\User;
use App\Courses;
use App\Models\Cohort;
use Auth;
use App\Http\Controllers\Site\Controller;
use Storage;
use Str;

class CommunityController extends Controller

{
    /**
     * عرض قائمة المجتمعات
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Check if user has admin role (role_id = 1)
        $isAdmin = $user->role == 1;
        if ($isAdmin) {
            // For admin users, get all active communities
            $courseCommunities = Community::where('type', 'course')
                ->where('is_active', true)
                ->get();

            $cohortCommunities = Community::where('type', 'cohort')
                ->where('is_active', true)
                ->get();
        } else {
            // For regular users, get only communities they have access to
            // مجتمعات الكورسات
            $courseCommunities = Community::where('type', 'course')
                ->where(function ($query) use ($user) {
                    $query->whereIn('reference_id', function ($subQuery) use ($user) {
                        $subQuery->select('course_id')
                            ->from('course_users')
                            ->where('user_id', $user->id);
                    })
                        ->orWhereIn('reference_id', function ($subQuery) use ($user) {
                            $subQuery->select('id')
                                ->from('courses')
                                ->where('user_id', $user->id);
                        });
                })
                ->where('is_active', true)
                ->get();

            // مجتمعات الأفواج
            $cohortCommunities = Community::where('type', 'cohort')
                ->whereIn('reference_id', function ($query) use ($user) {
                    $query->select('cohort_id')
                        ->from('cohort_trainees')
                        ->where('user_id', $user->id);
                })
                ->where('is_active', true)
                ->get();
        }
        // Get posts that are marked to be published in the general community
        $posts = Post::with(['user', 'likes', 'comments'])
            ->where('publish_to_general', true)
            ->withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            $postsHtml = view('community.partials.general_posts', compact('posts'))->render();
            return response()->json([
                'posts_html' => $postsHtml,
                'next_page_url' => $posts->nextPageUrl()
            ]);
        }

        return view('community.index', compact('courseCommunities', 'cohortCommunities', 'posts'));
    }


    /**
     * عرض مجتمع معين
     */
    public function show($id, Request $request)
    {
        $community = Community::findOrFail($id);

        // التحقق من صلاحية الوصول
        $this->authorize('view', $community);

        // الحصول على المنشورات مع التعليقات والإعجابات
        $posts = Post::where('community_id', $id)
            ->with(['user', 'comments.user', 'comments.likes', 'likes'])
            ->withCount(['comments', 'likes'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // إذا كان الطلب من AJAX (للتحميل اللانهائي)، أعد فقط جزء المنشورات
        if ($request->ajax()) {
            // تسجيل معلومات للتصحيح
            \Log::info('AJAX request for more posts', [
                'community_id' => $id,
                'page' => $request->input('page', 1)
            ]);

            return view('community.partials.posts', compact('community', 'posts'))->render();
        }

        return view('community.show', compact('community', 'posts'));
    }


    /**
     * عرض مجتمع كورس معين
     */
    public function course($courseId)
    {
        $community = Community::where('type', 'course')
            ->where('reference_id', $courseId)
            ->firstOrFail();

        return $this->show($community->id);
    }

    /**
     * عرض مجتمع فوج معين
     */
    public function cohort($cohortId)
    {
        $community = Community::where('type', 'cohort')
            ->where('reference_id', $cohortId)
            ->firstOrFail();

        return $this->show($community->id);
    }

    /**
     * إنشاء منشور جديد
     */
    public function storePost(Request $request, $communityId)
    {
        $community = Community::findOrFail($communityId);

        // التحقق من صلاحية الوصول
        $this->authorize('view', $community);

        try {
            // تسجيل معلومات الطلب للتصحيح
            \Log::info('Request data:', [
                'has_file' => $request->hasFile('media'),
                'content' => $request->input('content'),
                'all_data' => $request->all()
            ]);

            if ($request->hasFile('media')) {
                \Log::info('File details:', [
                    'original_name' => $request->file('media')->getClientOriginalName(),
                    'mime_type' => $request->file('media')->getMimeType(),
                    'size' => $request->file('media')->getSize(),
                    'error' => $request->file('media')->getError()
                ]);
            }

            // تحقق أساسي من البيانات
            $validated = $request->validate([
                'content' => 'nullable|string',
                'media' => 'nullable|file|max:256000', // 256MB max
            ]);

            $post = new Post();
            $post->community_id = $communityId;
            $post->user_id = Auth::id();
            $post->content = $validated['content'];
            $post->type = 'text'; // القيمة الافتراضية
            $post->publish_to_general = $request->has('publish_to_general') && $request->publish_to_general == 'on';

            $storageDisk = env('FILESYSTEM_DRIVER', 'contabo');
            $mediaUrl = null;

            // تحميل الملف إذا كان موجودًا
            if ($request->hasFile('media') && $request->file('media')->isValid()) {
                try {
                    $file = $request->file('media');
                    $extension = strtolower($file->getClientOriginalExtension());
                    $allowedExtensions = ['jpeg', 'png', 'jpg', 'gif', 'mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'wav', 'ogg'];

                    if (!in_array($extension, $allowedExtensions)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'نوع الملف غير مسموح به. الأنواع المسموح بها هي: ' . implode(', ', $allowedExtensions)
                        ], 422);
                    }

                    // استخدام اسم الملف الأصلي مع إضافة طابع زمني لتجنب تكرار الأسماء
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $filename . '_' . time() . '.' . $extension;

                    // تخزين الملف باستخدام اسم مخصص
                    $mediaUrl = $file->storeAs(
                        'community/media',
                        $newFilename,
                        $storageDisk
                    );

                    \Log::info('File stored successfully at: ' . $mediaUrl);

                    // تحديد نوع الملف بناءً على الامتداد
                    if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif'])) {
                        $post->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv'])) {
                        $post->type = 'video';
                    } elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                        $post->type = 'audio';
                    } else {
                        $post->type = 'file';
                    }
                } catch (\Exception $e) {
                    \Log::error('File upload error: ' . $e->getMessage(), [
                        'exception' => $e,
                        'trace' => $e->getTraceAsString()
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'حدث خطأ أثناء تحميل الملف: ' . $e->getMessage()
                    ], 500);
                }
            } elseif ($request->hasFile('media') && !$request->file('media')->isValid()) {
                $errorCode = $request->file('media')->getError();
                $errorMessage = $this->getUploadErrorMessage($errorCode);

                \Log::error('Invalid file upload: ' . $errorMessage);

                return response()->json([
                    'success' => false,
                    'message' => 'الملف المرفق غير صالح: ' . $errorMessage
                ], 422);
            }

            $post->media_url = $mediaUrl;
            $post->save();

            \Log::info('Post created successfully', ['post_id' => $post->id]);

            // إرسال إشعارات للمستخدمين في المجتمع
            $this->sendPostNotifications($community, $post);
            $post = Post::with('user')->find($post->id);
            $html = view('community.partials.posts', ['posts' => $community->posts, 'community' => $community])->render();
            event(new \App\Events\NewPost($post, $html));
            return response()->json([
                'success' => true,
                'message' => __('site.post_created_successfully'),
                'html' => $html
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ', [
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صالحة',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Post creation error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء المنشور: ' . $e->getMessage()
            ], 500);
        }
    }

    // دالة مساعدة لترجمة رموز أخطاء التحميل
    private function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'حجم الملف يتجاوز الحد المسموح به في إعدادات PHP (upload_max_filesize)';
            case UPLOAD_ERR_FORM_SIZE:
                return 'حجم الملف يتجاوز الحد المسموح به في النموذج (MAX_FILE_SIZE)';
            case UPLOAD_ERR_PARTIAL:
                return 'تم تحميل جزء من الملف فقط';
            case UPLOAD_ERR_NO_FILE:
                return 'لم يتم تحميل أي ملف';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'مجلد التحميل المؤقت مفقود';
            case UPLOAD_ERR_CANT_WRITE:
                return 'فشل في كتابة الملف على القرص';
            case UPLOAD_ERR_EXTENSION:
                return 'تم إيقاف التحميل بواسطة امتداد PHP';
            default:
                return 'خطأ غير معروف في التحميل';
        }
    }


    /**
     * تعديل منشور
     */
    public function editPost($id)
    {
        $post = Post::findOrFail($id);

        // التحقق من صلاحية التعديل
        $this->authorize('update', $post);

        return view('community.edit-post', compact('post'));
    }

    /**
     * تحديث منشور
     */
    /**
     * تحديث منشور
     */
    public function updatePost(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // التحقق من صلاحية التعديل
        $this->authorize('update', $post);

        try {
            // تسجيل معلومات الطلب للتصحيح
            \Log::info('Update post request data:', [
                'has_file' => $request->hasFile('media'),
                'content' => $request->input('content'),
                'type' => $request->input('type'),
                'remove_media' => $request->input('remove_media'),
                'all_data' => $request->all()
            ]);

            // تحقق أساسي من البيانات
            $validated = $request->validate([
                'content' => 'nullable|string',
                'media' => 'nullable|file|max:256000', // 256MB max
                'type' => 'nullable|string|in:text,image,video,audio,file',
                'remove_media' => 'nullable|boolean'
            ]);

            $post->content = $validated['content'];

            // إذا طلب المستخدم إزالة الوسائط
            if ($request->input('remove_media') == '1') {
                // حذف الملف القديم إذا كان موجودًا
                if ($post->media_url) {
                    $storageDisk = env('FILESYSTEM_DRIVER', 'contabo');
                    \Storage::disk($storageDisk)->delete($post->media_url);
                    $post->media_url = null;
                }
                $post->type = 'text';
            }
            // إذا تم تحميل ملف جديد
            elseif ($request->hasFile('media') && $request->file('media')->isValid()) {
                try {
                    $file = $request->file('media');
                    $extension = strtolower($file->getClientOriginalExtension());
                    $allowedExtensions = ['jpeg', 'png', 'jpg', 'gif', 'mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'wav', 'ogg'];

                    if (!in_array($extension, $allowedExtensions)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'نوع الملف غير مسموح به. الأنواع المسموح بها هي: ' . implode(', ', $allowedExtensions)
                        ], 422);
                    }

                    // حذف الملف القديم إذا كان موجودًا
                    if ($post->media_url) {
                        $storageDisk = env('FILESYSTEM_DRIVER', 'contabo');
                        \Storage::disk($storageDisk)->delete($post->media_url);
                    }

                    // استخدام اسم الملف الأصلي مع إضافة طابع زمني لتجنب تكرار الأسماء
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $filename . '_' . time() . '.' . $extension;

                    // تخزين الملف باستخدام اسم مخصص
                    $storageDisk = env('FILESYSTEM_DRIVER', 'contabo');
                    $mediaUrl = $file->storeAs(
                        'community/media',
                        $newFilename,
                        $storageDisk
                    );

                    \Log::info('File updated successfully at: ' . $mediaUrl);
                    $post->media_url = $mediaUrl;

                    // تحديد نوع الملف بناءً على الامتداد
                    if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif'])) {
                        $post->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv'])) {
                        $post->type = 'video';
                    } elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                        $post->type = 'audio';
                    } else {
                        $post->type = 'file';
                    }
                } catch (\Exception $e) {
                    \Log::error('File upload error during update: ' . $e->getMessage(), [
                        'exception' => $e,
                        'trace' => $e->getTraceAsString()
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'حدث خطأ أثناء تحميل الملف: ' . $e->getMessage()
                    ], 500);
                }
            } elseif ($request->hasFile('media') && !$request->file('media')->isValid()) {
                $errorCode = $request->file('media')->getError();
                $errorMessage = $this->getUploadErrorMessage($errorCode);

                \Log::error('Invalid file upload during update: ' . $errorMessage);

                return response()->json([
                    'success' => false,
                    'message' => 'الملف المرفق غير صالح: ' . $errorMessage
                ], 422);
            }

            $post->save();

            \Log::info('Post updated successfully', ['post_id' => $post->id]);

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error during update: ', [
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صالحة',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Post update error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث المنشور: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * حذف منشور
     */
    public function destroyPost($id)
    {
        $post = Post::findOrFail($id);

        // التحقق من صلاحية الحذف
        $this->authorize('delete', $post);

        // حذف الملف المرفق من Contabo إذا وجد
        if ($post->media_url) {
            $storageDisk = env('FILESYSTEM_DRIVER', 'contabo');
            try {
                \Storage::disk($storageDisk)->delete($post->media_url);
                \Log::info('Media file deleted successfully', ['media_url' => $post->media_url]);
            } catch (\Exception $e) {
                \Log::error('Error deleting media file: ' . $e->getMessage(), [
                    'media_url' => $post->media_url,
                    'exception' => $e,
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        // حذف التعليقات والإعجابات المرتبطة بالمنشور
        $post->comments()->delete();
        $post->likes()->delete();

        $post->delete();

        return response()->json(['success' => true]);
    }

    /**
     * تثبيت/إلغاء تثبيت منشور
     */
    public function pinPost($id)
    {
        $post = Post::findOrFail($id);

        // التحقق من صلاحية التثبيت (يجب أن يكون مدرس الكورس أو مشرف)
        $this->authorize('pin', $post);

        $post->is_pinned = !$post->is_pinned;
        $post->save();

        return response()->json(['success' => true]);
    }

    /**
     * الإعجاب بمنشور
     */
    public function likePost($id)
    {
        $post = Post::findOrFail($id);

        // التحقق من صلاحية الوصول للمجتمع
        $this->authorize('view', $post->community);

        $userId = Auth::id();
        $liked = $post->likes()->where('user_id', $userId)->exists();

        if ($liked) {
            // إلغاء الإعجاب
            $post->likes()->where('user_id', $userId)->delete();
            $likes_count = $post->likes()->count();
            return response()->json(['success' => true, 'liked' => false, 'likes_count' => $likes_count]);
        } else {

            // إضافة إعجاب
            $post->likes()->create(['user_id' => $userId]);

            // إرسال إشعار للمستخدم صاحب المنشور إذا لم يكن هو نفسه
            if ($post->user_id != $userId) {
                $this->createNotification(
                    $post->user_id,
                    Auth::user()->user_name . ' أعجب بمنشورك',
                    1,
                    route('community.show', $post->community_id)
                );
            }
            $likes_count = $post->likes()->count();
            $communityId = $post->community_id;

            event(new \App\Events\NewLike($post->id, 'post', $likes_count, $communityId));
            return response()->json(['success' => true, 'liked' => true, 'likes_count' => $likes_count]);
        }
    }

    /**
     * إضافة تعليق
     */
    public function storeComment(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($validated['post_id']);

        // التحقق من صلاحية الوصول للمجتمع
        $this->authorize('view', $post->community);

        $comment = new Comment();
        $comment->post_id = $validated['post_id'];
        $comment->user_id = Auth::id();
        $comment->content = $validated['content'];

        if (isset($validated['parent_id'])) {
            $comment->parent_id = $validated['parent_id'];
        }

        $comment->save();

        // إرسال إشعار للمستخدم صاحب المنشور إذا لم يكن هو نفسه
        if ($post->user_id != Auth::id()) {
            $this->createNotification(
                $post->user_id,
                Auth::user()->user_name . ' علق على منشورك',
                1,
                route('community.show', $post->community_id)
            );
        }

        // إذا كان الرد على تعليق، أرسل إشعارًا لصاحب التعليق الأصلي
        if (isset($validated['parent_id'])) {
            $parentComment = Comment::find($validated['parent_id']);
            if ($parentComment && $parentComment->user_id != Auth::id()) {
                $this->createNotification(
                    $parentComment->user_id,
                    Auth::user()->user_name . ' رد على تعليقك',
                    1,
                    route('community.show', $post->community_id)
                );
            }
        }
        $comment = Comment::with('user')->find($comment->id);

        if ($comment->parent_id) {
            // إذا كان رد على تعليق
            $html = view('community.partials.reply', ['reply' => $comment])->render();
        } else {
            // إذا كان تعليق عادي
            $html = view('community.partials.comment', ['comment' => $comment])->render();
        }
        event(new \App\Events\NewComment($comment, $html));
        return response()->json([
            'success' => true,
            'message' => $comment->parent_id ? __('site.reply_added_successfully') : __('site.comment_added_successfully'),
            'html' => $html
        ]);
        return response()->json(['success' => true]);
    }

    /**
     * تعديل تعليق
     */
    public function editComment($id)
    {
        $comment = Comment::findOrFail($id);

        // التحقق من صلاحية التعديل
        $this->authorize('update', $comment);

        return view('community.edit-comment', compact('comment'));
    }

    /**
     * تحديث تعليق
     */
    public function updateComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        // التحقق من صلاحية التعديل
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->content = $validated['content'];
        $comment->save();
        return response()->json(['success' => true]);
    }

    /**
     * حذف تعليق
     */
    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);

        // التحقق من صلاحية الحذف
        $this->authorize('delete', $comment);

        // حذف الردود على التعليق
        $comment->replies()->delete();

        // حذف الإعجابات بالتعليق
        $comment->likes()->delete();

        $comment->delete();

        return response()->json(['success' => true]);
    }

    /**
     * الإعجاب بتعليق
     */
    public function likeComment($id)
    {
        $comment = Comment::findOrFail($id);

        // التحقق من صلاحية الوصول للمجتمع
        $this->authorize('view', $comment->post->community);

        $userId = Auth::id();
        $liked = $comment->likes()->where('user_id', $userId)->exists();

        if ($liked) {
            // إلغاء الإعجاب
            $comment->likes()->where('user_id', $userId)->delete();
            $likes_count = $comment->likes()->count();
            return response()->json(['success' => true, 'liked' => false, 'likes_count' => $likes_count]);
        } else {
            // إضافة إعجاب
            $comment->likes()->create(['user_id' => $userId]);

            // إرسال إشعار للمستخدم صاحب التعليق إذا لم يكن هو نفسه
            if ($comment->user_id != $userId) {
                $this->createNotification(
                    $comment->user_id,
                    Auth::user()->user_name . ' أعجب بتعليقك',
                    1,
                    route('community.show', $comment->post->community_id)
                );
            }
            $likes_count = $comment->likes()->count();

            return response()->json(['success' => true, 'liked' => true, 'likes_count' => $likes_count]);
        }
    }

    /**
     * عرض الدردشة الخاصة بمجتمع معين
     */
    public function chat($id)
    {
        $community = Community::findOrFail($id);

        // التحقق من صلاحية الوصول
        $this->authorize('view', $community);

        // الحصول على الأعضاء
        $members = [];

        if ($community->type == 'course') {
            // الحصول على مدرس الكورس والمتدربين
            // الحصول على مدرس الكورس والمتدربين
            $course = Courses::findOrFail($community->reference_id);
            $members = $course->users;

            // إضافة مدرس الكورس إذا لم يكن موجودًا بالفعل
            if (!$members->contains($course->user)) {
                $members->push($course->user);
            }
        } else {
            // الحصول على متدربي الفوج
            $cohort = Cohort::findOrFail($community->reference_id);
            $members = $cohort->trainees;
        }

        // الحصول على الرسائل
        $messages = Message::where('community_id', $id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        // تحديث حالة قراءة الرسائل
        Message::where('community_id', $id)
            ->where('user_id', '!=', Auth::id())
            ->update(['is_read' => true]);

        return view('community.chat', compact('community', 'members', 'messages'));
    }

    /**
     * إرسال رسالة في الدردشة
     */
    public function sendMessage(Request $request, $communityId)
    {
        $community = Community::findOrFail($communityId);

        // التحقق من صلاحية الوصول
        $this->authorize('view', $community);

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $message = new Message();
        $message->community_id = $communityId;
        $message->user_id = Auth::id();
        $message->content = $validated['content'];
        $message->is_read = false;
        $message->save();

        // تحضير بيانات الرسالة للرد
        $messageData = [
            'id' => $message->id,
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->user_name,
            'user_image' => Auth::user()->image ? asset('uploads/' . Auth::user()->image) : asset('admin/assets/media/users/300_21.jpg'),
            'content' => $message->content,
            'time' => $message->created_at->format('h:i A')
        ];

        return response()->json([
            'success' => true,
            'message' => $messageData
        ]);
    }

    /**
     * الحصول على رسائل جديدة
     */
    public function getMessages(Request $request, $communityId)
    {
        $community = Community::findOrFail($communityId);

        // التحقق من صلاحية الوصول
        $this->authorize('view', $community);

        $lastId = $request->input('last_id', 0);

        $messages = Message::where('community_id', $communityId)
            ->where('id', '>', $lastId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        $formattedMessages = [];

        foreach ($messages as $message) {
            $formattedMessages[] = [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'user_name' => $message->user->user_name,
                'user_image' => $message->user->image ? asset('uploads/' . $message->user->image) : asset('admin/assets/media/users/300_21.jpg'),
                'content' => $message->content,
                'time' => $message->created_at->format('h:i A')
            ];

            // تحديث حالة قراءة الرسالة إذا لم تكن من المستخدم الحالي
            if ($message->user_id != Auth::id()) {
                $message->is_read = true;
                $message->save();
            }
        }

        // الحصول على عدد المستخدمين المتصلين
        $onlineUsers = $this->getOnlineUsersCount($communityId);

        return response()->json([
            'messages' => $formattedMessages,
            'online_users_count' => $onlineUsers
        ]);
    }

    /**
     * الحصول على المستخدمين المتصلين
     */
    public function getOnlineUsers($communityId)
    {
        $community = Community::findOrFail($communityId);

        // التحقق من صلاحية الوصول
        $this->authorize('view', $community);

        // في تطبيق حقيقي، يمكن استخدام Redis أو قاعدة بيانات لتتبع المستخدمين المتصلين
        // هنا نستخدم طريقة بسيطة للتوضيح

        $onlineUsers = [];

        if ($community->type == 'course') {
            $course = Courses::findOrFail($community->reference_id);
            $members = $course->users;

            // إضافة مدرس الكورس
            if (!$members->contains($course->user)) {
                $members->push($course->user);
            }

            // اعتبار المستخدمين الذين أرسلوا رسائل في آخر 5 دقائق متصلين
            foreach ($members as $member) {
                $recentMessage = Message::where('community_id', $communityId)
                    ->where('user_id', $member->id)
                    ->where('created_at', '>=', now()->subMinutes(5))
                    ->exists();

                if ($recentMessage || $member->id == Auth::id()) {
                    $onlineUsers[] = $member->id;
                }
            }
        } else {
            $cohort = Cohort::findOrFail($community->reference_id);
            $members = $cohort->trainees;

            // اعتبار المستخدمين الذين أرسلوا رسائل في آخر 5 دقائق متصلين
            foreach ($members as $member) {
                $recentMessage = Message::where('community_id', $communityId)
                    ->where('user_id', $member->id)
                    ->where('created_at', '>=', now()->subMinutes(5))
                    ->exists();

                if ($recentMessage || $member->id == Auth::id()) {
                    $onlineUsers[] = $member->id;
                }
            }
        }

        return response()->json([
            'users' => $onlineUsers
        ]);
    }

    /**
     * الحصول على عدد المستخدمين المتصلين
     */
    private function getOnlineUsersCount($communityId)
    {
        // في تطبيق حقيقي، يمكن استخدام Redis أو قاعدة بيانات لتتبع المستخدمين المتصلين
        // هنا نستخدم طريقة بسيطة للتوضيح

        $onlineCount = Message::where('community_id', $communityId)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->distinct('user_id')
            ->count('user_id');

        // إضافة المستخدم الحالي إذا لم يكن قد أرسل رسائل مؤخرًا
        $currentUserSentRecently = Message::where('community_id', $communityId)
            ->where('user_id', Auth::id())
            ->where('created_at', '>=', now()->subMinutes(5))
            ->exists();

        if (!$currentUserSentRecently) {
            $onlineCount++;
        }

        return $onlineCount;
    }

    /**
     * إرسال إشعارات للمستخدمين في المجتمع عند إنشاء منشور جديد
     */
    private function sendPostNotifications($community, $post)
    {
        $members = [];

        if ($community->type == 'course') {
            $course = Courses::findOrFail($community->reference_id);
            $members = $course->users;

            // إضافة مدرس الكورس
            if (!$members->contains($course->user)) {
                $members->push($course->user);
            }
        } else {
            $cohort = Cohort::findOrFail($community->reference_id);
            $members = $cohort->trainees;
        }

        foreach ($members as $member) {
            // لا ترسل إشعارًا للمستخدم الذي أنشأ المنشور
            if ($member->id != Auth::id()) {
                $this->createNotification(
                    $member->id,
                    Auth::user()->user_name . ' أضاف منشورًا جديدًا في مجتمع ' . $community->name,
                    1,
                    route('community.show', $community->id)
                );
            }
        }
    }

    /**
     * إنشاء إشعار جديد
     */
    private function createNotification($userId, $message, $type, $link = null)
    {
        $notification = new \App\Models\Notification();
        $notification->user_id = $userId;
        $notification->message = $message;
        $notification->type = $type;
        $notification->link = $link;
        $notification->datetime = now();
        $notification->save();
    }

    /**
     * إنشاء مجتمع جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:course,cohort',
            'reference_id' => 'required|integer',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        $data = $request->except('cover_image');
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // معالجة الصورة إذا تم رفعها
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension();
            $newFilename = Str::random(20) . '.' . $extension;
            $storageDisk = 'contabo';

            $mediaUrl = $file->storeAs(
                'community/media',
                $newFilename,
                $storageDisk
            );

            $data['cover_image'] = $mediaUrl;
        }

        Community::create($data);

        return redirect()->back()->with('success', 'تم إنشاء المجتمع بنجاح');
    }

    /**
     * جلب بيانات المجتمع للتعديل
     */
    public function edit($id)
    {
        $community = Community::findOrFail($id);
        return response()->json($community);
    }

    /**
     * تحديث بيانات المجتمع
     */
    public function update(Request $request)
    {
        $request->validate([
            'community_id' => 'required|exists:communities,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        $community = Community::findOrFail($request->community_id);

        $data = $request->except(['community_id', 'cover_image', '_token', '_method']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // معالجة الصورة إذا تم رفعها
        if ($request->hasFile('cover_image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($community->cover_image) {
                Storage::disk('contabo')->delete($community->cover_image);
            }

            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension();
            $newFilename = Str::random(20) . '.' . $extension;
            $storageDisk = 'contabo';

            $mediaUrl = $file->storeAs(
                'community/media',
                $newFilename,
                $storageDisk
            );

            $data['cover_image'] = $mediaUrl;
        }

        $community->update($data);

        return redirect()->back()->with('success', 'تم تحديث المجتمع بنجاح');
    }

    public function loadMorePosts(Request $request, $communityId)
    {
        $community = Community::findOrFail($communityId);
        $posts = Post::where('community_id', $communityId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $postsHtml = view('community.partials.posts', [
            'posts' => $posts,
            'community' => $community
        ])->render();

        return response()->json([
            'posts_html' => $postsHtml,
            'next_page_url' => $posts->nextPageUrl()
        ]);
    }

    public function general(Request $request)
    {
        // Get posts marked for general community with pagination
        $posts = Post::with(['user', 'likes', 'comments.user', 'comments.likes', 'comments.replies.user', 'comments.replies.likes'])
            ->where('publish_to_general', true)
            ->withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get trending posts (most liked/commented)
        $trendingPosts = Post::with('user')
            ->where('publish_to_general', true)
            ->withCount(['likes', 'comments'])
            ->orderByRaw('(likes_count + comments_count) DESC')
            ->limit(5)
            ->get();

        // Get statistics
        $postsCount = Post::where('publish_to_general', true)->count();
        $commentsCount = Comment::whereIn('post_id', function ($query) {
            $query->select('id')->from('posts')->where('publish_to_general', true);
        })->count();
        $usersCount = User::count();
        $createdAt = '2023-01-01'; // Set this to when your general community was created

        return view('community.general', compact(
            'posts',
            'trendingPosts',
            'postsCount',
            'commentsCount',
            'usersCount',
            'createdAt'
        ));
    }
    public function generalPosts()
    {
        $posts = Post::with(['user', 'likes', 'comments'])
            ->where('publish_to_general', true)
            ->withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('community.general_posts', compact('posts'));
    }

    /**
     * تبديل حالة النشر العام للمنشور
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglePublicPost($id)
    {
        $post = Post::findOrFail($id);

        // التحقق من الصلاحيات
        if (auth()->id() != $post->user_id && auth()->user()->role != 1) {
            return response()->json([
                'success' => false,
                'message' => __('site.unauthorized_action')
            ]);
        }

        // تحديث حالة النشر
        $post->publish_to_general = !$post->publish_to_general;
        $post->save();

        return response()->json([
            'success' => true,
            'is_public' => $post->publish_to_general,
            'message' => $post->publish_to_general
                ? __('site.post_published_to_general_successfully')
                : __('site.post_unpublished_from_general_successfully')
        ]);
    }
}