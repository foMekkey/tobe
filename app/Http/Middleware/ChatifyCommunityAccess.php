<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cohort;
use Illuminate\Support\Facades\Auth;

class ChatifyCommunityAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the community ID from the request or session
        $communityId = $request->route('groupId') ?? session('current_community_id');

        if (!$communityId) {
            return redirect()->route('home')->with('error', 'No community selected');
        }

        // Check if the user is a member of this community
        $community = Cohort::findOrFail($communityId);
        $isMember = $community->users()->where('user_id', Auth::id())->exists();

        if (!$isMember) {
            return redirect()->route('home')->with('error', 'You are not a member of this community');
        }

        // Store the community ID in the session for future requests
        session(['current_community_id' => $communityId]);

        return $next($request);
    }
}