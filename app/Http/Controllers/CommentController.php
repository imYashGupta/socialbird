<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Comment;
use App\Events\Notify;
use App\Notification;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
     {
        $comment=new Comment();
        $comment->user_id =auth()->user()->id;
        $comment->comment =$request->comment;
        $comment->post_id =$request->post_id; 
        $comment->save();
            //activity logging
            Activity::create(["user_id" => auth()->user()->id,"type" => "comment","data" => $comment->id]);
            $post=Post::find($request->post_id);
            if ($post->user_id!=auth()->user()->id) {
                $notification=Notification::create(["user_id" => auth()->user()->id,"user_to_notify"=>$post->user_id,"type" => "comment","data" => $comment->id]);
                 $sendNotification=Notification::where('id',$notification->id)->with('user')->first();
                
                broadcast(new Notify($sendNotification));
            }
        $commentCreated=Comment::where('id',$comment->id)->with('user')->first();
        return response()->json(["comment" => $commentCreated],200);
    }

    public function edit(Request $request)
     {
         $comment=Comment::where('id',$request->id)->where('user_id',auth()->user()->id)->first();
         if ($comment) {
             $comment->comment =$request->comment;
             $comment->update();
             return response()->json(["comment" => $comment],200);
         }
         else{
             return response()->json([],401);
         }
     }

     public function fetch(Request $request)
    {
        $postID=$request->post_id;
        $omitComment=$request->comment;
        $post=Post::find($postID);
        if ($post) {
            if (isset($omitComment) AND $omitComment!=0) {
                $GetOmitedComment=Comment::where('user_id',auth()->user()->id)->limit($omitComment)->pluck('id')->toArray();
                $comment=Comment::where('post_id',$postID)->where('id','!=',$GetOmitedComment)->with('user')->latest()->paginate(10);

            }
            else{
                $comment=Comment::where('post_id',$postID)->with('user')->latest()->paginate(10);
            }
            return response()->json(["comments" => $comment],200);
        }
        else{
             return response()->json([],401);
        }
    }

    public function fetch2(Request $request)
    {
        $postID=$request->post_id;
        $post=Post::find($postID);
        if ($post) {
            $comment=Comment::where('post_id',$postID)->with('user')->latest()->paginate(10);
            return response()->json(["comments" => $comment],200);
        }
        else{
             return response()->json([],401);
        }
    } 

    public function delete(Request $request)
    {
        $commentId=$request->commentId;
        $comment=Comment::where('id',$commentId)->where('user_id',auth()->user()->id)->first();
        if ($comment) {
            $comment->delete();
            $activity=Activity::where('user_id',auth()->user()->id)->where('type','comment')->where('data',$commentId)->first();
            $notification=Notification::where('user_id',auth()->user()->id)->where('type','comment')->where('data',$commentId)->first();
            $notification->delete();
            $activity->delete();
            return response()->json([],200);
        }
        else{
            return response()->json(401);
        }
    }
}
 