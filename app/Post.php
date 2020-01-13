<?php

namespace App;

use App\React;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    

	    public function user()
    {
    	return $this->belongsTo('App\User');
    }


      public function getCreatedAtAttribute($date)
	{
        //return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d M,y h:i A');
	    return Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
	}

        public function comments()
    {
        return $this->hasMany('App\Comment');
    }
 

        public function reacts()
    {
        return $this->hasMany('App\React');
    }


    protected $appends = ['isLiked','extra','options','media'];
     public function getIsLikedAttribute()
     {
        $react=React::where('user_id',auth()->user()->id)->where('post_id',$this->id)->exists();
        return $react;
     }

     public function getMediaAttribute()
     {
        if ($this->images==1) {
            $image=UserImage::where('post_id',$this->id)->get();
            return ["image" => $image];
        }
        else{
            return false;
        }
     }

     public function getExtraAttribute()
     {
         return false;
     }

         public function getOptionsAttribute()
     {
         return ["showComments" => false];
     }
 
}
