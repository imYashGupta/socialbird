<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\React;
use App\User;
use App\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create(Request $request){
        $post =new Post();
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;
        $post->is_deleted = 0;
        $post->images = '';
        $post->save();
        $PostData=Post::where('id',$post->id)->with('user')->withCount('comments')->withCount('reacts')->get();
        return response()->json(["response" => ["code" => 1,"message" => "Post Created!"],"post" => $PostData],200);
    } 

    //V2 created for Post with Image Upload
    public function createV2(Request $request)
    {
        $image= $request->file('image');
        $isImage=false;
        $text=$request->text;
        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpeg,png|max:2000',
            'text' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $post =new Post();
        $post->body=$request->text; //Text
        $post->user_id=auth()->user()->id; //Text
        isset($image) ? $post->images=1 : $post->images=0; // is Post Contain Image
        $post->is_deleted = 0; // post Deleted (setting default value)
        if (isset($image)) {
            $imageName=time().'_'.$image->getClientOriginalName(); //Image name
            if ($image->move('images/posts/', $imageName)) {
                $isImage=true;   
                $post->images = 1;
            }
        }
        else{
            $post->images = 0;
        }
        $post->save();
        if ($isImage) {
            $postImage = new userImage();
            $postImage->user_id=auth()->user()->id; 
            $postImage->post_id=$post->id;
            $postImage->name=$imageName;
            $postImage->type="post";
            $postImage->current="0";
            $postImage->save();
        }
        $PostData=Post::where('id',$post->id)->with('user')->withCount('comments')->withCount('reacts')->get();
        return response()->json(["response" => ["code" => 1,"message" => "Post Created!"],"post" => $PostData],200);
         
    }

    public function feed(Request $req)
    {
        if ($req->mode=='explore') {    
            $posts=Post::where('is_deleted','=','0')
                        ->with('user')
                        ->withCount('reacts')
                        ->withCount('comments')
                        ->orderBy('created_at', 'DESC')
                        ->get();
        }
        else{
            $posts = Post::orderBy('created_at', 'DESC')->with('user')->withCount('comments')->withCount('reacts')->whereIn('user_id', function ($query) {
                $query->select('following')
                ->from('follows')
                ->where('user_id', Auth::user()->id);
                })->orWhere('user_id',Auth::user()->id)->where('is_deleted','=','0')->get(); 
        }
        return response()->json(["response" => ["code" => 1],"posts" => $posts]);
    }

    public function delete(Request $request)
    {
        $post=Post::where('id',$request->id)->first();
        if ($post->images==1) {
            $postImage=UserImage::where('post_id',$post->id)->first();
            $postImage->delete();
        }
        $post->is_deleted = 1;
        $post->update();
        return response()->json(["response" => ["code" => 1]]);
    }

    public function update(Request $request)
    {
        $post=Post::where('id',$request->id)->first();
        $post->body = $request->body;
        $post->update();
        return response()->json(["response" => ["code" => 1]]);
    }

    public function reactionsList(Request $request)
    {
        $reacts=React::where('post_id',$request->postID)->with('user')->latest()->get();
        return response()->json(["reacts" => $reacts]);
    }

    public function post(Request $request)
    {
        $id=$request->id;
        $post=Post::where('is_deleted','0')->with('user')->find($id);
        $reacts=React::where('post_id',$id)->count();
        $commentsCount=Comment::where('post_id',$id)->count();

        $comments=Comment::where('post_id',$id)->with('user')->latest()->paginate(10);
        if ($post) {
            return response()->json(["request" => 1,"post" => $post,"comments" => $comments,"reactCount" => $reacts,"commentCount" => $commentsCount],200);
        }
        else{
            return response()->json(["request" => 0]);
        }
    }

    public function userPosts(Request $req)
    {
        $user=User::where('username',$req->username)->first();
        $posts=Post::where('is_deleted','=','0')
            ->where('user_id',$user->id)
            ->with('user')
            ->withCount('reacts')
            ->withCount('comments')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        return response()->json($posts);
    }
}
