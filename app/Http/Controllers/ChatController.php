<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Conversation;
use App\Events\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    //
    public function ChatHeads()
    {
    	$user=auth()->user();
    	$convo=Conversation::where('sender',$user->id)
    				->orWhere('reciver',$user->id)
    				->pluck('id')->toArray();
    	$chats=[];
    	foreach ($convo as $key) {
    		$chats[]=Chat::where('conversation_id',$key)->latest()->first();			
    	}
    	return response()->json($chats);
    }
    /*
     requires Username
     */
    public function GetConversationID($anotherUsername)
    {
    	$user=User::where('username',$anotherUsername)->first();
		$userID=$user->id;
		$authUserID=auth()->user()->id;
		$convoID=DB::table('conversations')
			->whereRaw("sender='$authUserID' AND reciver='$userID'")
			->orWhereRaw("sender='$userID' AND reciver='$authUserID'")
			->get();
			if ($convoID) {
			 	return @$convoID[0]->id;
			}
			else{
				return false;
			}
		
    }
    public function conversations(Request $request)
    {
    	$anotherUsername=$request->username;
    	$user=User::where('username',$anotherUsername)->first();
    	if ($user) {
    		$conversationID=$this->GetConversationID($anotherUsername);
    		if ($conversationID) {
    			$chat=Chat::where('conversation_id',$conversationID)->orderBy('created_at','ASC')->get();
    			return response()->json(["conversation" => $chat,"user" => $user]);
    		}
    		else{
    			return response()->json(["conversation" => [],"user" => $user]);
    		}
    	}
    	else{
    		return response()->json([],400);
    	}

    }
    public function sendMessage(Request $request)
    {	
    	if ($this->GetConversationID($request->username)) {
	    	$user=User::validateUsername($request->username);
	    	if ($user) {
		    	$message=Chat::create([
		    		'conversation_id' 	=> $this->GetConversationID($request->username),
		    		'sender'			=> auth()->user()->id,
		    		'reciver'			=> $user->id,
		    		'text'				=> $request->text,
		    	]);
		    	$chat=Chat::where('conversation_id',$message->conversation_id)->first();
		    	broadcast(new Message($message));
		    	return response()->json(["message" => $message],200);

	    	}
	    	else{
		    	return response()->json([],400);
	    	}
    	}
    	else{
	    	$user=User::validateUsername($request->username);
	    	if ($user) {
	    		$convo=new Conversation();
		    	$convo->sender =auth()->user()->id;
		    	$convo->reciver=$user->id;
		    	$convo->save();

		    	$message=Chat::create([
		    		'conversation_id' 	=> $convo->id,
		    		'sender'			=> auth()->user()->id,
		    		'reciver'			=> $user->id,
		    		'text'				=> $request->text,
		    	]);
		    	//broadcast(new Message($message));
		    	return response()->json(["message" => $message,"first" => true],200);	
	    	}
	    	else{
		    	return response()->json([],400);
	    	}

    	}

    }
}
