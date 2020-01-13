<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Pusher\Pusher;
class BroadcastAuthController extends Controller
{
    /**
     * Authenticate
     * @param  Request $request
     * @return Response
     */
    public function auth(Request $request)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
/*
        PUSHER_APP_ID=792017
PUSHER_APP_KEY=23f492b624fa5f0e6bfb
PUSHER_APP_SECRET=f3f9abbb78eaa2cd1bd7
PUSHER_APP_CLUSTER=ap2*/

          return Broadcast::auth($request);
        //return response()->json( config('broadcasting.connections.pusher'));

    }
}