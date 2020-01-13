<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable=["user_id","user_to_notify","data","type"];
 
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
    		return ["user" => $user];
    	}
 		if ($this->type=='react') {
            $user=User::find($this->user_id);
 			return ["user" => $user,"post" => $this->data];
 		}
 		if ($this->type=='comment') {
 			$comment=Comment::where('id',$this->data)->with('user')->first();
 			return ["comment" => $comment];
 		}
    }

    public function getCreatedAtAttribute($date)
    {
        //return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d M,y h:i A');
        return Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
    }
}
