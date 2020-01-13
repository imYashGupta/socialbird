<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Feedback;
use App\Follow;
use App\Notification;
use App\Post;
use App\User;
use App\UserImage;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function user()
    {
    	$user=Auth::user();
    	$following=Follow::where('user_id',$user->id)->count();
    	$followers=Follow::where('following',$user->id)->count();
    	$posts=Post::where('is_deleted','=','0')->where('user_id',$user->id)->count();
        $notifications=Notification::with('user')->where('user_to_notify',$user->id)->latest()->limit(10)->get();
    	$response=[
    		"user" => Auth::user(),
    		"info" => [
    			"posts" 		=> $posts,
    			"followings"	=> $following,
    			"followers"		=> $followers,
    			"status"		=> ''
            ],
    	   "notifications" => $notifications 
    	];
    	return response()->json($response,200);
    }
    // new beta profile
    public function userProfile(Request $request)
    {
        $username =$request->username;
        $user=User::where('username',$username)->first();
        $followers=Follow::where('following',$user->id)->with('user')->get();
        $following=Follow::where('user_id',$user->id)->with('following')->get();

        return response()->json(["user" => $user,"followers" => $followers,"followings" => $following]);
    }
    //new
    public function getUser()
    {
        return response()->json(Auth::user());    
    }

    public function setUser(Request $request)
    {
        if ($request->username==auth()->user()->username) {
            if ($request->type=='basic') {
                $user=User::where('username',$request->username)->first();
                $usermeta=UserMeta::where('user_id',$user->id)->first();
                $user->firstname = $request->firstname;
                $user->lastname = $request->lastname;
                $usermeta->title = $request->title;
                $usermeta->country = $request->country;
                $usermeta->city = $request->city;
                $usermeta->social = json_encode($request->social);
                $user->update();
                $usermeta->update();
                return response()->json($user,200);
                
            }
        }
        else{
            return response()->json([],400);
        }
    }

    public function updateBackground(Request $request)
    {
        if ($request->username==auth()->user()->username) {
            $user=User::where('username',auth()->user()->username)->first();
            $userinfo=json_decode($user->userinfo);
            $encodeInfo=json_encode(["avatar" => $userinfo->avatar,"background" => $request->background]);
            $user->userinfo=$encodeInfo;
            $user->save();
            return response()->json($user);

        }
        else{
            return response()->json([],400);
        }
    }

    public function updateImage(Request $request)
    {
        $user=auth()->user();
        if ($request->image) {
            $base64URI=explode(',',$request->image);
            $image=base64_decode($base64URI[1]);
            if (str_contains($base64URI[0],'jpeg')) {
                $extension='jpg';
            }
            else if (str_contains($base64URI[0],'png')){
                $extension='png';
            }
            else{
                return response()->json(["Bad Method!"],400);
            }

            $filename=time().'_'.auth()->user()->id.'.'.$extension;
            $path=public_path().'/images/profile/account/'.$filename;
            file_put_contents($path,$image);
            $checkForPreviousImage=UserImage::where('user_id',$user->id)
                                            ->where('type','account')
                                            ->where('current','1')
                                            ->first();
            if ($checkForPreviousImage) {
                $checkForPreviousImage->current='0';
                $checkForPreviousImage->update();
            }
            $userImage=new UserImage();
            $userImage->user_id=$user->id;
            $userImage->name=$filename;
            $userImage->type='account';
            $userImage->current='1';
            $userImage->save();    
            return response()->json($userImage);
        }
    }

    public function images(Request $request)
    {
        $username=$request->username;
        $user=$this->validateUsername($username);

        if ($user) {
                $photosAll=UserImage::where('user_id',$user->id)->latest()->get(); 
                $photosPost=UserImage::where('user_id',$user->id)->where('type','post')->latest()->get();
                $photosProfile=UserImage::where('user_id',$user->id)->where('type','account')->latest()->get();   
            return response()->json(["photos" => ["all" => $photosAll,"posts" => $photosPost,"profile" => $photosProfile]],200);
        }
        return response()->json([],400);
            
    }
    
    public function start(Request $request)
    {
        $user=auth()->user();   
        $userinfo=UserMeta::where('user_id',$user->id)->first();
        $userinfo->country=$request->country;
        $userinfo->state=$request->state;
        $userinfo->city=$request->city;
        $userinfo->birthdate=$request->birthdate;
        $userinfo->update();
        return response()->json([],200);
    }

    public function feedback(Request $request)
    {
        $image= $request->file('image');
        $message=$request->message;
        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpeg,png|max:2000',
            'feedback' => 'required'
        ]);
        $feedback=new Feedback();
        $feedback->feedback=$message;
        $feedback->user_id=auth()->user()->id;
        $feedback->ip_address=$this->getUserIP();
        if (isset($image)) {
            $imageName=time()."_".$image->getClientOriginalName();
            $image->move('/images/feedback',$imageName);
            $feedback->image=$imageName;
        }
        $feedback->save();
        return response()->json(["message" => "feedback Sent.","code" => "200"],200);
    }

    public function getUserByUsername(Request $request)
    {
    	$username= $request->username;

    	$user=User::where('username',$username)->first();
    	if ($user) {
    		$following=Follow::where('user_id',$user->id)->count();
    		$followers=Follow::where('following',$user->id)->count();
    		$posts=Post::where('is_deleted','=','0')
    				->where('user_id',$user->id)
                    ->with('user')
                    
                    ->withCount('reacts')
                    ->withCount('comments')
                    ->orderBy('created_at', 'DESC')
                    ->get();

    	   	$response=[
	    		"user" => $user,
	    		"info" => [
	    			"followings"	=> $following,
	    			"followers"		=> $followers,
	    			"status"		=> '',
	    		],
	    		"posts" 		=> $posts,
    		];		
    		return response()->json(["user" => $response]);
    	}
    	else{
    		return response()->json(["user" => null]);
    	}
    }
    //new for Beta 2.0
    public function updateUser(Request $request)
    {
        
    }
    public function update(Request $request)
    {
        if ($request->username==Auth::user()->username) {
            $validator = Validator::make($request->all(), [
                'firstname' => "required|max:24",
                'lastname' => "required|max:24"
            ]);

            if ($validator->fails()) {
               return response()->json(["response" => $validator->errors()],200);
            }
            $user=User::where('id',Auth::user()->id)->first();
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;

            $usermeta=UserMeta::where('user_id',$user->id)->first();
                if ($usermeta) {
                    $usermeta->title    = $request->title;
                    $usermeta->country  = $request->country;
                    $usermeta->city     = $request->city;
                    $usermeta->update();
                }
                else{
                    $usermeta=new UserMeta();
                    $usermeta->user_id  = $user->id;
                    $usermeta->title    = $request->title;
                    $usermeta->country  = $request->country;
                    $usermeta->city     = $request->city;
                    $usermeta->save();
                }
            if ($request->profile) {
                $base64URI=explode(',',$request->profile);
                $image=base64_decode($base64URI[1]);
                if (str_contains($base64URI[0],'jpeg')) {
                    $extension='jpg';
                }
                else{
                    $extension='png';
                }

                $filename=time().'_'.auth()->user()->id.'.'.$extension;
                $path=public_path().'/images/profile/account/'.$filename;
                file_put_contents($path,$image);
                $checkForPreviousImage=UserImage::where('user_id',$user->id)
                                                ->where('type','account')
                                                ->where('current','1')
                                                ->first();
                if ($checkForPreviousImage) {
                    $checkForPreviousImage->current='0';
                    $checkForPreviousImage->update();
                }
                $userImage=new UserImage();
                $userImage->user_id=$user->id;
                $userImage->name=$filename;
                $userImage->type='account';
                $userImage->current='1';
                $userImage->save();    
            }
            if ($user->update()) {
                return response()->json(["user updated"]);
            }
            else{
                return response()->json(["error"]);     
            }
            
        }

    }

    public function validateUserByUsername(Request $request)
    {
        $user=User::where('username',$request->username)->first();
        if ($user) {
            return response()->json($user,200);
        }
        else{
            return response()->json([],400);
        }
    }

    static function validateUsername($username)
    {
        $user=User::where('username',$username)->first();
        return $user;
    }

    public function randomAvatar()
    {
        $avatarClass=["primary "," success "," warning "," danger "," info "," light "," dark "," red "," green "," pink "," purple "," violet "," indigo "," blue "," sky "," cyan "," teal "," neon "," lime "," sun "," yellow "," orange "," pumpkin "," brown "," grey "," gold "," smoke"];
            $randomClass=array_rand($avatarClass);
            return trim($avatarClass[$randomClass]);
    }

    public function activity(Request $request)
    {
        $user=User::where('username',$request->username)->first();
        if ($user) {
            $activity=Activity::with('user')->where('user_id',$user->id)->latest()->get();
            return response()->json($activity,200);
        }
        else{
            return response()->json([],400);
        }
    }

    public function readNotification(Request $request)
    {
        $id=$request->id;
        $notification=Notification::where("id",$id)->with('user')->first();
    
        $notification->read=1;
        $notification->update();
        return response()->json($notification,200);

    }

    public function search(Request $request)
    {
        if ($request->type=='user') {
            $users=User::where('firstname','LIKE',"%$request->text%")->orWhere('lastname','LIKE',"%$request->text%")->get();
            return response()->json(["user" => $users,"results" => $users->count()]);
        }
        
         
    }

    function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if(filter_var($client, FILTER_VALIDATE_IP))        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }
        else{
            $ip = $remote;
        }
        return $ip;
    }

}
