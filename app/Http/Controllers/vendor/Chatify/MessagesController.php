<?php

namespace App\Http\Controllers\vendor\Chatify;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use App\User;
use App\Models\ChMessage as Message;
use App\Models\ChFavorite as Favorite;
use App\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;
use App\Community;


class MessagesController extends Controller
{
    protected $perPage = 30;

    /**
     * Authenticate the connection for pusher
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function pusherAuth(Request $request)
    {
        return Chatify::pusherAuth(
            $request->user(),
            Auth::user(),
            $request['channel_name'],
            $request['socket_id']
        );
    }

    /**
     * Returning the view of the app with the required data.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, $id = null)
    {
        if ($request->community) {
            \Cache::put('community' . Auth::id(), \Crypt::decrypt($request->community), now()->addDays(30));
        }
        $messenger_color = Auth::user()->messenger_color;
        return view('Chatify::pages.app', [
            'id' => $id ?? 0,
            'messengerColor' => $messenger_color ? $messenger_color : Chatify::getFallbackColor(),
            'dark_mode' => Auth::user()->dark_mode < 1 ? 'light' : 'dark',
        ]);
    }


    /**
     * Fetch data (user, favorite.. etc).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function idFetchData(Request $request)
    {
        $favorite = Chatify::inFavorite($request['id']);
        $fetch = User::where('id', $request['id'])->first();
        if ($fetch) {
            $userAvatar = Chatify::getUserWithAvatar($fetch)->avatar;
            $fetch->name = $fetch->f_name . ' ' . $fetch->l_name;
        }
        return Response::json([
            'favorite' => $favorite,
            'fetch' => $fetch ?? null,
            'user_avatar' => $userAvatar ?? null,
        ]);
    }

    /**
     * This method to make a links for the attachments
     * to be downloadable.
     *
     * @param string $fileName
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|void
     */
    public function download($fileName)
    {
        $filePath = config('chatify.attachments.folder') . '/' . $fileName;
        if (Chatify::storage()->exists($filePath)) {
            return Chatify::storage()->download($filePath);
        }
        return abort(404, "Sorry, File does not exist in our server or may have been deleted!");
    }

    /**
     * Send a message to database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request)
    {
        // default variables
        $error = (object)[
            'status' => 0,
            'message' => null
        ];
        $attachment = null;
        $attachment_title = null;

        // if there is attachment [file]
        if ($request->hasFile('file')) {
            // allowed extensions
            $allowed_images = Chatify::getAllowedImages();
            $allowed_files  = Chatify::getAllowedFiles();
            $allowed        = array_merge($allowed_images, $allowed_files);

            $file = $request->file('file');
            // check file size
            if ($file->getSize() < Chatify::getMaxUploadSize()) {
                if (in_array(strtolower($file->extension()), $allowed)) {
                    // get attachment name
                    $attachment_title = $file->getClientOriginalName();
                    // upload attachment and store the new name
                    $attachment = Str::uuid() . "." . $file->extension();
                    $file->storeAs(config('chatify.attachments.folder'), $attachment, config('chatify.storage_disk_name'));
                } else {
                    $error->status = 1;
                    $error->message = "File extension not allowed!";
                }
            } else {
                $error->status = 1;
                $error->message = "File size you are trying to upload is too large!";
            }
        }

        if (!$error->status) {
            $message = Chatify::newMessage([
                'from_id' => Auth::user()->id,
                'to_id' => $request['id'],
                'body' => htmlentities(trim($request['message']), ENT_QUOTES, 'UTF-8'),
                'attachment' => ($attachment) ? json_encode((object)[
                    'new_name' => $attachment,
                    'old_name' => htmlentities(trim($attachment_title), ENT_QUOTES, 'UTF-8'),
                ]) : null,
            ]);
            $messageData = Chatify::parseMessage($message);
            if (Auth::user()->id != $request['id']) {
                Chatify::push("private-chatify." . $request['id'], 'messaging', [
                    'from_id' => Auth::user()->id,
                    'to_id' => $request['id'],
                    'message' => Chatify::messageCard($messageData, true)
                ]);
            }
        }

        // send the response
        return Response::json([
            'status' => '200',
            'error' => $error,
            'message' => Chatify::messageCard(@$messageData),
            'tempID' => $request['temporaryMsgId'],
        ]);
    }

    /**
     * fetch [user/group] messages from database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetch(Request $request)
    {
        $query = Chatify::fetchMessagesQuery($request['id'])->latest();
        $messages = $query->paginate($request->per_page ?? $this->perPage);
        $totalMessages = $messages->total();
        $lastPage = $messages->lastPage();
        $response = [
            'total' => $totalMessages,
            'last_page' => $lastPage,
            'last_message_id' => collect($messages->items())->last()->id ?? null,
            'messages' => '',
        ];

        // if there is no messages yet.
        if ($totalMessages < 1) {
            $response['messages'] = '<p class="message-hint center-el"><span>Say \'hi\' and start messaging</span></p>';
            return Response::json($response);
        }
        if (count($messages->items()) < 1) {
            $response['messages'] = '';
            return Response::json($response);
        }
        $allMessages = null;
        foreach ($messages->reverse() as $message) {
            $allMessages .= Chatify::messageCard(
                Chatify::parseMessage($message)
            );
        }
        $response['messages'] = $allMessages;
        return Response::json($response);
    }

    /**
     * Make messages as seen
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function seen(Request $request)
    {
        // make as seen
        $seen = Chatify::makeSeen($request['id']);
        // send the response
        return Response::json([
            'status' => $seen,
        ], 200);
    }

    /**
     * Get contacts list
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getContacts(Request $request)
    {
        $community = \Cache::get('community' . Auth::id());

        // إذا كان المستخدم الحالي هو admin
        if (Auth::user()->role === 1) {
            $users = User::where('id', '!=', Auth::user()->id)
                ->orderBy('user_name')
                ->paginate($request->per_page ?? $this->perPage);
        } else {
            if ($community) {
                // جلب معرفات المستخدمين المنتمين للمجتمع المحدد
                $communityUsers = [];

                // جلب مستخدمي المجتمع من نوع course
                $courseCommunity = Community::where('id', $community)
                    ->where('type', 'course')
                    ->first();

                if ($courseCommunity && $courseCommunity->course) {
                    // جلب المستخدمين المسجلين في الكورس
                    $courseUsers = $courseCommunity->course->users()->pluck('users.id')->toArray();
                    $communityUsers = array_merge($communityUsers, $courseUsers);

                    // إضافة مدرب الكورس إذا كان موجودًا
                    if ($courseCommunity->course->user_id) {
                        $communityUsers[] = $courseCommunity->course->user_id;
                    }
                }

                // جلب مستخدمي المجتمع من نوع cohort
                $cohortCommunity = Community::where('id', $community)
                    ->where('type', 'cohort')
                    ->first();

                if ($cohortCommunity && $cohortCommunity->cohort) {
                    // جلب المتدربين في الفوج
                    $cohortUsers = $cohortCommunity->cohort->trainees()->pluck('users.id')->toArray();
                    $communityUsers = array_merge($communityUsers, $cohortUsers);
                }

                // جلب المستخدمين المنتمين للمجتمع أو الذين لديهم دور admin
                $users = User::where('id', '!=', Auth::user()->id)
                    ->where(function ($query) use ($communityUsers) {
                        $query->whereIn('id', $communityUsers)
                            ->orWhere('role', 1);
                    })
                    ->orderBy('user_name')
                    ->paginate($request->per_page ?? $this->perPage);
            } else {
                // إذا لم يكن هناك مجتمع محدد، اجلب فقط المستخدمين الذين لديهم دور admin
                $users = User::where('id', '!=', Auth::user()->id)
                    ->where('role', 1)
                    ->orderBy('user_name')
                    ->paginate($request->per_page ?? $this->perPage);
            }
        }

        $usersList = $users->items();

        if (count($usersList) > 0) {
            $contacts = '';
            foreach ($usersList as $user) {
                $contacts .= Chatify::getContactItem($user);
            }
        } else {
            $contacts = '<p class="message-hint center-el"><span>Your contact list is empty</span></p>';
        }

        return Response::json([
            'contacts' => $contacts,
            'total' => $users->total() ?? 0,
            'last_page' => $users->lastPage() ?? 1,
        ], 200);
    }


    /**
     * Update user's list item data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateContactItem(Request $request)
    {
        // Get user data
        $user = User::where('id', $request['user_id'])->first();
        if (!$user) {
            return Response::json([
                'message' => 'User not found!',
            ], 401);
        }

        // تأكد من أن Chatify يستخدم user_name بدلاً من name
        if (!isset($user->name)) {
            $user->name = $user->user_name;
        }

        $contactItem = Chatify::getContactItem($user);

        // send the response
        return Response::json([
            'contactItem' => $contactItem,
        ], 200);
    }

    /**
     * Put a user in the favorites list
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function favorite(Request $request)
    {
        $userId = $request['user_id'];
        // check action [star/unstar]
        $favoriteStatus = Chatify::inFavorite($userId) ? 0 : 1;
        Chatify::makeInFavorite($userId, $favoriteStatus);

        // send the response
        return Response::json([
            'status' => @$favoriteStatus,
        ], 200);
    }

    /**
     * Get favorites list
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function getFavorites(Request $request)
    {
        $favoritesList = null;
        $favorites = Favorite::where('user_id', Auth::user()->id);
        foreach ($favorites->get() as $favorite) {
            // get user data
            $user = User::where('id', $favorite->favorite_id)->first();
            $favoritesList .= view('Chatify::layouts.favorite', [
                'user' => $user,
            ]);
        }
        // send the response
        return Response::json([
            'count' => $favorites->count(),
            'favorites' => $favorites->count() > 0
                ? $favoritesList
                : 0,
        ], 200);
    }


    /**
     * Search in messenger
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function search(Request $request)
    {
        $getRecords = null;
        $input = trim(filter_var($request['input']));
        $community = \Cache::get('community' . Auth::id());

        // إذا كان المستخدم الحالي هو admin
        if (Auth::user()->role === 1) {
            $records = User::where('id', '!=', Auth::user()->id)
                ->where(function ($query) use ($input) {
                    $query->where('user_name', 'LIKE', "%{$input}%")
                        ->orWhere('f_name', 'LIKE', "%{$input}%")
                        ->orWhere('l_name', 'LIKE', "%{$input}%");
                })
                ->paginate($request->per_page ?? $this->perPage);
        } else {
            if ($community) {
                // جلب معرفات المستخدمين المنتمين للمجتمع المحدد
                $communityUsers = [];

                // جلب مستخدمي المجتمع من نوع course
                $courseCommunity = Community::where('id', $community)
                    ->where('type', 'course')
                    ->first();

                if ($courseCommunity && $courseCommunity->course) {
                    // جلب المستخدمين المسجلين في الكورس
                    $courseUsers = $courseCommunity->course->users()->pluck('users.id')->toArray();
                    $communityUsers = array_merge($communityUsers, $courseUsers);

                    // إضافة مدرب الكورس إذا كان موجودًا
                    if ($courseCommunity->course->user_id) {
                        $communityUsers[] = $courseCommunity->course->user_id;
                    }
                }

                // جلب مستخدمي المجتمع من نوع cohort
                $cohortCommunity = Community::where('id', $community)
                    ->where('type', 'cohort')
                    ->first();

                if ($cohortCommunity && $cohortCommunity->cohort) {
                    // جلب المتدربين في الفوج
                    $cohortUsers = $cohortCommunity->cohort->trainees()->pluck('users.id')->toArray();
                    $communityUsers = array_merge($communityUsers, $cohortUsers);
                }

                // جلب المستخدمين المنتمين للمجتمع أو الذين لديهم دور admin
                $records = User::where('id', '!=', Auth::user()->id)
                    ->where(function ($query) use ($communityUsers) {
                        $query->whereIn('id', $communityUsers)
                            ->orWhere('role', 1);
                    })
                    ->where(function ($query) use ($input) {
                        $query->where('user_name', 'LIKE', "%{$input}%")
                            ->orWhere('f_name', 'LIKE', "%{$input}%")
                            ->orWhere('l_name', 'LIKE', "%{$input}%");
                    })
                    ->orderBy('user_name')
                    ->paginate($request->per_page ?? $this->perPage);
            } else {
                // إذا لم يكن هناك مجتمع محدد، اجلب فقط المستخدمين الذين لديهم دور admin
                $records = User::where('id', '!=', Auth::user()->id)
                    ->where('role', 1)
                    ->where(function ($query) use ($input) {
                        $query->where('user_name', 'LIKE', "%{$input}%")
                            ->orWhere('f_name', 'LIKE', "%{$input}%")
                            ->orWhere('l_name', 'LIKE', "%{$input}%");
                    })
                    ->orderBy('user_name')
                    ->paginate($request->per_page ?? $this->perPage);
            }
        }

        foreach ($records->items() as $record) {
            $getRecords .= view('Chatify::layouts.listItem', [
                'get' => 'search_item',
                'user' => Chatify::getUserWithAvatar($record),
            ])->render();
        }

        if ($records->total() < 1) {
            $getRecords = '<p class="message-hint center-el"><span>Nothing to show.</span></p>';
        }

        // send the response
        return Response::json([
            'records' => $getRecords,
            'total' => $records->total(),
            'last_page' => $records->lastPage()
        ], 200);
    }



    /**
     * Get shared photos
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function sharedPhotos(Request $request)
    {
        $shared = Chatify::getSharedPhotos($request['user_id']);
        $sharedPhotos = null;

        // shared with its template
        for ($i = 0; $i < count($shared); $i++) {
            $sharedPhotos .= view('Chatify::layouts.listItem', [
                'get' => 'sharedPhoto',
                'image' => Chatify::getAttachmentUrl($shared[$i]),
            ])->render();
        }
        // send the response
        return Response::json([
            'shared' => count($shared) > 0 ? $sharedPhotos : '<p class="message-hint"><span>Nothing shared yet</span></p>',
        ], 200);
    }

    /**
     * Delete conversation
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteConversation(Request $request)
    {
        // delete
        $delete = Chatify::deleteConversation($request['id']);

        // send the response
        return Response::json([
            'deleted' => $delete ? 1 : 0,
        ], 200);
    }

    /**
     * Delete message
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteMessage(Request $request)
    {
        // delete
        $delete = Chatify::deleteMessage($request['id']);

        // send the response
        return Response::json([
            'deleted' => $delete ? 1 : 0,
        ], 200);
    }

    public function updateSettings(Request $request)
    {
        $msg = null;
        $error = $success = 0;

        // dark mode
        if ($request['dark_mode']) {
            $request['dark_mode'] == "dark"
                ? User::where('id', Auth::user()->id)->update(['dark_mode' => 1])  // Make Dark
                : User::where('id', Auth::user()->id)->update(['dark_mode' => 0]); // Make Light
        }

        // If messenger color selected
        if ($request['messengerColor']) {
            $messenger_color = trim(filter_var($request['messengerColor']));
            User::where('id', Auth::user()->id)
                ->update(['messenger_color' => $messenger_color]);
        }
        // if there is a [file]
        if ($request->hasFile('avatar')) {
            // allowed extensions
            $allowed_images = Chatify::getAllowedImages();

            $file = $request->file('avatar');
            // check file size
            if ($file->getSize() < Chatify::getMaxUploadSize()) {
                if (in_array(strtolower($file->extension()), $allowed_images)) {
                    // delete the older one
                    if (Auth::user()->avatar != config('chatify.user_avatar.default')) {
                        $avatar = Auth::user()->avatar;
                        if (Chatify::storage()->exists($avatar)) {
                            Chatify::storage()->delete($avatar);
                        }
                    }
                    // upload
                    $avatar = Str::uuid() . "." . $file->extension();
                    $update = User::where('id', Auth::user()->id)->update(['avatar' => $avatar]);
                    $file->storeAs(config('chatify.user_avatar.folder'), $avatar, config('chatify.storage_disk_name'));
                    $success = $update ? 1 : 0;
                } else {
                    $msg = "File extension not allowed!";
                    $error = 1;
                }
            } else {
                $msg = "File size you are trying to upload is too large!";
                $error = 1;
            }
        }

        // send the response
        return Response::json([
            'status' => $success ? 1 : 0,
            'error' => $error ? 1 : 0,
            'message' => $error ? $msg : 0,
        ], 200);
    }

    /**
     * Set user's active status
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function setActiveStatus(Request $request)
    {
        $activeStatus = $request['status'] > 0 ? 1 : 0;
        $status = User::where('id', Auth::user()->id)->update(['active_status' => $activeStatus]);
        return Response::json([
            'status' => $status,
        ], 200);
    }

    /**
     * Get all users
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllUsers(Request $request)
    {
        // جلب جميع المستخدمين باستثناء المستخدم الحالي
        $users = User::where('id', '!=', Auth::user()->id)
            ->orderBy('user_name')
            ->paginate($request->per_page ?? $this->perPage);

        $usersList = $users->items();

        if (count($usersList) > 0) {
            $allUsers = '';
            foreach ($usersList as $user) {
                // تأكد من أن المستخدم لديه صورة رمزية
                $user = Chatify::getUserWithAvatar($user);

                // إضافة المستخدم إلى القائمة
                $allUsers .= view('Chatify::layouts.listItem', [
                    'get' => 'all_users',
                    'user' => $user,
                ])->render();
            }
        } else {
            $allUsers = '<p class="message-hint center-el"><span>No users found</span></p>';
        }

        return Response::json([
            'users' => $allUsers,
            'total' => $users->total() ?? 0,
            'last_page' => $users->lastPage() ?? 1,
        ], 200);
    }
}