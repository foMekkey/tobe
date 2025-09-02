<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Chatify\Http\Controllers\MessagesController;

class CommunityChatsController extends Controller
{
    protected $messagesController;

    public function __construct()
    {
        $this->messagesController = new MessagesController();
        $this->middleware('chatify.community');
    }

    public function index($groupId)
    {
        // Store the current community ID in session
        session(['current_community_id' => $groupId]);

        // Get the community details
        $community = Cohort::findOrFail($groupId);

        // Get community members
        $members = $community->users()->get();

        // Pass the community data to the view
        return view('chatify.pages.app', [
            'community' => $community,
            'members' => $members
        ]);
    }

    // You can override other Chatify methods here as needed
    // For example, to filter messages by community

    public function send(Request $request)
    {
        // Add community ID to the message
        $request->merge(['community_id' => session('current_community_id')]);

        // Call the original send method
        return $this->messagesController->send($request);
    }

    public function fetch(Request $request)
    {
        // Filter messages by community
        $communityId = session('current_community_id');

        // You'll need to modify the query in the MessagesController
        // For now, we'll just call the original method
        return $this->messagesController->fetch($request);
    }
}