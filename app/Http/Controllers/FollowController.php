<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Events\Notify;
use App\Follow;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    //
    public function follow(Request $request)
	{ 
		//validade Following User!
		$user=User::where('id',$request->following)->first();
		if ($user!==null AND $request->following!=Auth::user()->id) {
			$checkIfAlreadyExists=Follow::where('user_id',Auth::user()->id)->where('following',$request->following)->first();
			if ($checkIfAlreadyExists!==null) {
				$checkIfAlreadyExists->delete();
				//activity logging
				$activity=Activity::where('user_id',auth()->user()->id)->where('type','follow')->where('data',$request->following)->first();
				$notification=Notification::where('user_id',auth()->user()->id)->where('type','follow')->where('user_to_notify',$request->following)->first();
				
				$activity->delete();
				$notification->delete();
				return response()->json(["follow" => false],200);
			}
			else{
				$follow=new Follow();
				$follow->user_id=Auth::user()->id;
				$follow->following=$request->following;
				$follow->save();
				//activity logging
				Activity::create([
					"user_id" => auth()->user()->id,
					"type"	=> "follow",
					"data"	=> $request->following
				]);
                $notification=Notification::create(["user_id" => auth()->user()->id,"user_to_notify"=> $request->following,"type" => "follow","data" => auth()->user()->id]);
                 $sendNotification=Notification::where('id',$notification->id)->with('user')->first();
		    	broadcast(new Notify($sendNotification));
				return response()->json(["follow" => true],200); 
			}
		}

		return response()->json(["msg" => "Thats an error! we're working on it."],400); 
	}
	public function followSuggestion()
	{
		 
        $followingIds =User::following();
		$suggestions=User::whereNotIn('id', $followingIds)
					->where('id', '!=', auth()->user()->id)
					->inRandomOrder()
					->limit(5)
					->get();
					
		return response()->json(["suggestions" => $suggestions],200);
	}

	public function followerList(Request $request)
	{
		$username=$request->username;
		$user=User::where('username',$username)->first();
		if ($user) {
			$followers=Follow::where('following',$user->id)->with('user')->get();
			return response()->json(["username" => $username,"followers" => $followers],200);
		}
	}

		public function followingList(Request $request)
	{
		$username=$request->username;
		$user=User::where('username',$username)->first();
		if ($user) {
			$following=Follow::where('user_id',$user->id)->with('following')->paginate(20);
			return response()->json(["username" => $username,"followings" => $following],200);
		}
	}

	 
}
