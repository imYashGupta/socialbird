<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
	protected $appends=["followers","followings"];
    //
     public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getFollowersAttribute()
    {
		 $follower= Follow::where('following',$this->user_id)->count();
         $following=Follow::where('user_id',$this->user_id)->count();
        return ['following' => $following,'follower' => $follower];
    }
 
    public function getFollowingsAttribute()
    {
        $following= Follow::where('user_id',$this->following)->count();
        $follower=Follow::where('following',$this->following)->count();
        return ['following' => $following,'follower' => $follower];
    }
    public function following()
    {
        return $this->belongsTo('App\User','following','id');
    }
}
