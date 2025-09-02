<?php

namespace App\Services\Chatify;

use App\User;
use App\Models\ChMessage;
use App\Models\ChFavorite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Pusher\Pusher;

class ChatifyMessenger
{
    /**
     * Allowed extensions to upload attachment
     * [Images / Files]
     *
     * @var
     */
    public $allowed_images = ['png', 'jpg', 'jpeg', 'gif'];
    public $allowed_files  = ['zip', 'rar', 'txt', 'doc', 'docx', 'pdf', 'xls', 'xlsx', 'ppt', 'pptx', 'odt', 'csv'];

    /**
     * Get max file's upload size in MB.
     *
     * @return int
     */
    public function getMaxUploadSize()
    {
        return config('chatify.attachments.max_upload_size') * 1048576;
    }

    /**
     * Get user list's item data [Contact Item]
     * (e.g. User data, Last message, Unread Counter...)
     *
     * @param int $messenger_id
     * @param Collection $user
     * @return string
     */
    public function getContactItem($user)
    {
        $allUsers = User::all();
        // get last message
        $lastMessage = ChMessage::where('from_id', Auth::user()->id)->where('to_id', $user->id)
            ->orWhere('from_id', $user->id)->where('to_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')->first();

        // Get Unseen messages counter
        $unseenCounter = ChMessage::where('from_id', $user->id)->where('to_id', Auth::user()->id)->where('seen', 0)->count();

        // Ensure the user has a name property
        if (!isset($user->name) && isset($user->user_name)) {
            $user->name = $user->user_name;
        }

        return view('Chatify::layouts.listItem', [
            'get' => 'users',
            'user' => $this->getUserWithAvatar($user),
            'lastMessage' => $lastMessage,
            'unseenCounter' => $unseenCounter,
            'allUsers' => $allUsers,
        ])->render();
    }

    /**
     * Add a user to the favorites list
     *
     * @param Request $request
     * @return void
     */
    public function makeInFavorite($user_id, $star)
    {
        if ($star == 1) {
            // Star
            $favorite = new ChFavorite();
            $favorite->user_id = Auth::user()->id;
            $favorite->favorite_id = $user_id;
            $favorite->save();
        } else {
            // Unstar
            $favorite = ChFavorite::where('user_id', Auth::user()->id)->where('favorite_id', $user_id)->delete();
        }
    }

    /**
     * Check if a user in the favorite list
     *
     * @param int $user_id
     * @return boolean
     */
    public function inFavorite($user_id)
    {
        return ChFavorite::where('user_id', Auth::user()->id)->where('favorite_id', $user_id)->count() > 0;
    }

    /**
     * Get user with avatar (formatted).
     *
     * @param Collection $user
     * @return Collection
     */
    public function getUserWithAvatar($user)
    {
        if ($user->avatar == 'avatar.png' && config('chatify.user_avatar.default')) {
            $user->avatar = config('chatify.user_avatar.default');
        } else {
            $user->avatar = asset('/storage/' . config('chatify.user_avatar.folder') . '/' . $user->avatar);
        }

        // Ensure the user has a name property
        if (!isset($user->name) && isset($user->user_name)) {
            $user->name =  $user->f_name . ' -- ' . $user->l_name;
        }

        return $user;
    }

    /**
     * Check if user is in favorite list
     *
     * @param int $user_id
     * @return boolean
     */
    public function getUserAvatarUrl($user_avatar_name)
    {
        return asset('/storage/' . config('chatify.user_avatar.folder') . '/' . $user_avatar_name);
    }

    /**
     * Return a message card with the given data.
     *
     * @param Message $data
     * @param boolean $renderDefaultCard
     * @return string
     */
    public function messageCard($data, $renderDefaultCard = false)
    {
        if (!$data) {
            return '';
        }

        $data['isSender'] = ($data['from_id'] == Auth::user()->id);

        return view('Chatify::layouts.messageCard', [
            'data' => $data,
            'renderDefaultCard' => $renderDefaultCard,
        ])->render();
    }

    /**
     * Default messenger's color
     *
     * @return string
     */
    public function getFallbackColor()
    {
        return config('chatify.colors.default');
    }

    /**
     * Fetch & parse message and return the message card.
     *
     * @param Message $message
     * @return array
     */
    public function parseMessage($message)
    {
        $attachment = null;
        $attachment_type = null;
        $attachment_title = null;

        if ($message->attachment) {
            $attachmentOBJ = json_decode($message->attachment);
            $attachment = $attachmentOBJ->new_name;
            $attachment_title = htmlentities(trim($attachmentOBJ->old_name), ENT_QUOTES, 'UTF-8');

            $ext = pathinfo($attachment, PATHINFO_EXTENSION);
            $attachment_type = in_array($ext, $this->allowed_images) ? 'image' : 'file';
        }

        return [
            'id' => $message->id,
            'from_id' => $message->from_id,
            'to_id' => $message->to_id,
            'message' => $message->body,
            'attachment' => [
                'file' => $attachment,
                'title' => $attachment_title,
                'type' => $attachment_type
            ],
            'timeAgo' => $message->created_at->diffForHumans(),
            'created_at' => $message->created_at->toIso8601String(),
            'isSeen' => $message->seen,
        ];
    }

    /**
     * Return a storage instance.
     *
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function storage()
    {
        return Storage::disk(config('chatify.storage_disk_name'));
    }

    /**
     * Get user messenger color.
     *
     * @return string
     */
    public function getUserMessengerColor()
    {
        return Auth::user()->messenger_color ?? $this->getFallbackColor();
    }

    /**
     * Get the API route for the messenger.
     *
     * @return string
     */
    public function getApiRoute($api_route)
    {
        return config('chatify.api_routes.' . $api_route);
    }

    /**
     * Get the web route for the messenger.
     *
     * @return string
     */
    public function getRoute($route)
    {
        return config('chatify.routes.' . $route);
    }

    /**
     * Generate an access token for the Pusher API.
     *
     * @param Request $request
     * @param User $auth
     * @param string $channelName
     * @param string $socket_id
     * @return string
     */
    public function pusherAuth($request, $auth, $channelName, $socket_id)
    {
        $pusher = new Pusher(
            config('chatify.pusher.key'),
            config('chatify.pusher.secret'),
            config('chatify.pusher.app_id'),
            config('chatify.pusher.options'),
        );

        if (Auth::check()) {
            return $pusher->socket_auth($channelName, $socket_id);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    /**
     * Trigger an event using Pusher
     *
     * @param string $channel
     * @param string $event
     * @param array $data
     * @return void
     */
    public function push($channel, $event, $data)
    {
        $pusher = new Pusher(
            config('chatify.pusher.key'),
            config('chatify.pusher.secret'),
            config('chatify.pusher.app_id'),
            config('chatify.pusher.options'),
        );

        return $pusher->trigger($channel, $event, $data);
    }

    /**
     * Get allowed image extensions
     *
     * @return array
     */
    public function getAllowedImages()
    {
        return $this->allowed_images;
    }

    /**
     * Get allowed file extensions
     *
     * @return array
     */
    public function getAllowedFiles()
    {
        return $this->allowed_files;
    }

    /**
     * Returns an array of shared photos
     *
     * @param int $user_id
     * @return array
     */
    public function getSharedPhotos($user_id)
    {
        $images = array();

        // Get messages with attachments
        $msgs = ChMessage::where('from_id', Auth::user()->id)->where('to_id', $user_id)
            ->orWhere('from_id', $user_id)->where('to_id', Auth::user()->id)
            ->where('attachment', '!=', null)
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($msgs as $msg) {
            $attachment = json_decode($msg->attachment);
            $ext = pathinfo($attachment->new_name, PATHINFO_EXTENSION);

            if (in_array($ext, $this->allowed_images)) {
                array_push($images, $attachment->new_name);
            }
        }

        return $images;
    }

    /**
     * Get attachment's url
     *
     * @param string $fileName
     * @return string
     */
    public function getAttachmentUrl($fileName)
    {
        return asset(config('chatify.attachments.folder') . '/' . $fileName);
    }

    /**
     * Create a new message
     *
     * @param array $data
     * @return Message
     */
    public function newMessage($data)
    {
        $message = new ChMessage();
        $message->from_id = $data['from_id'];
        $message->to_id = $data['to_id'];
        $message->body = $data['body'];
        $message->attachment = $data['attachment'];

        // Add community_id if it exists in the data
        if (isset($data['community_id'])) {
            $message->community_id = $data['community_id'];
        }

        $message->save();

        return $message;
    }

    /**
     * Delete conversation
     *
     * @param int $user_id
     * @return boolean
     */
    public function deleteConversation($user_id)
    {
        try {
            foreach (ChMessage::where('from_id', Auth::user()->id)->where('to_id', $user_id)->get() as $message) {
                $message->delete();
            }

            foreach (ChMessage::where('from_id', $user_id)->where('to_id', Auth::user()->id)->get() as $message) {
                $message->delete();
            }

            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    /**
     * Delete message
     *
     * @param int $id
     * @return boolean
     */
    public function deleteMessage($id)
    {
        try {
            $message = ChMessage::where('from_id', Auth::user()->id)->where('id', $id)->firstOrFail();
            $message->delete();

            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    /**
     * Fetch user's messages
     *
     * @param int $user_id
     * @return Collection
     */
    public function fetchMessagesQuery($user_id)
    {
        return ChMessage::where('from_id', $user_id)->where('to_id', Auth::user()->id)
            ->orWhere('from_id', Auth::user()->id)->where('to_id', $user_id)
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    /**
     * Mark messages as seen
     *
     * @param int $user_id
     * @return boolean
     */
    public function makeSeen($user_id)
    {
        try {
            ChMessage::where('from_id', $user_id)
                ->where('to_id', Auth::user()->id)
                ->where('seen', 0)
                ->update(['seen' => 1]);

            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    /**
     * Get last message for a specific user
     *
     * @param int $user_id
     * @return Message|null
     */
    public function getLastMessageQuery($user_id)
    {
        return ChMessage::where('from_id', Auth::user()->id)->where('to_id', $user_id)
            ->orWhere('from_id', $user_id)->where('to_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    /**
     * Count Unseen messages
     *
     * @param int $user_id
     * @return int
     */
    public function countUnseenMessages($user_id)
    {
        return ChMessage::where('from_id', $user_id)->where('to_id', Auth::user()->id)->where('seen', 0)->count();
    }


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