<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Chat extends Model
{
    //
       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conversation_id', 'sender', 'reciver','text'
    ];
    protected $appends=["senderInfo","senderMsgInfo"];

    public function getSenderinfoAttribute()
    {
    	$sender=User::where('id',$this->sender)->first();
    	if ($sender->id==auth()->user()->id) {
    		$reciver=User::where('id',$this->reciver)->first();
    		return ["user" => $reciver,"sender" => true]; 
    	}
    	return ["user" => $sender,"sender" => false]; 
    	
    }

        public function getSendermsginfoAttribute()
    {
        $sender=User::where('id',$this->sender)->first();
        if ($sender->id==auth()->user()->id) {
            $reciver=User::where('id',$this->sender)->first();
            return ["user" => $reciver,"sender" => true]; 
        }
        return ["user" => $sender,"sender" => false]; 
        
    }



          public function getCreatedAtAttribute($date)
	{
        //return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d M,y h:i A');
	    return Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
	}
}
