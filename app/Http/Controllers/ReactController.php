<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Events\Notify;
use App\Notification;
use App\Post;
use App\React;
use Illuminate\Http\Request;

class ReactController extends Controller
{
    //
    public function react(Request $request)
    {
    	$postID=$request->postID;
    	$validatePost=Post::find($postID);
    	if ($validatePost) {
    		$checkIfExists=React::where('user_id',auth()->user()->id)->where('post_id',$postID)->where('react',1)->first();
    		if ($checkIfExists) {
    			$checkIfExists->delete();
                $activity=Activity::where('user_id',auth()->user()->id)->where('type','react')->where('data',$postID)->first();
                $notification=Notification::where('user_id',auth()->user()->id)->where('type','react')->where('data',$postID)->first();
                if ($notification) {
                    $notification->delete();
                }
                $activity->delete();
    			return response()->json(["res" => 0],200);
    		}
    		else{
    			$react=React::create([
    				"user_id" => auth()->user()->id,
    				"post_id" => $postID,
    				"react"	  => 1
    			]);
                Activity::create([
                    "user_id" => auth()->user()->id,
                    "type"     => "react",
                    "data"      => $postID
                ]);
                if ($validatePost->user_id!=auth()->user()->id) {
                    $notification=Notification::create([
                        "user_id" => auth()->user()->id,
                        "user_to_notify"    => $validatePost->user_id,
                        "type"     => "react",
                        "data"      => $postID
                    ]);
                    $sendNotification=Notification::where('id',$notification->id)->with('user')->first();
                    broadcast(new Notify($sendNotification));
                }
    			return response()->json(["res" => 1,"react" => $react],200);
    		}
    	}
    	else{
    		return response()->json([],401);
    	}
    }
}
