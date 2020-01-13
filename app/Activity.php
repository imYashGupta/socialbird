<?php

namespace App;

use App\Follow;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $fillable=["user_id","data","type"];
    protected $hidden=["data"];
    protected $appends=["info"];

       public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getInfoAttribute()
    {
    	if ($this->type=='follow') {
    		$user=User::find($this->data);
    		$followCount=Follow::where('following',$this->data)->count();
    		return ["user" => $user,"followerCount" => $followCount];

    	}
 		if ($this->type=='react') {
 			$post=Post::with('user')->where('id',$this->data)->withCount('comments')->withCount('reacts')->first();
 			return ["post" => $post];
 		}

 		if ($this->type=='comment') {
 			$comment=Comment::find($this->data);
 			return ["comment" => $comment];
 		}
    	return $this->data;
    }

    public function getCreatedAtAttribute($date)
    {
        //return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d M,y h:i A');
        return Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
    }


}
