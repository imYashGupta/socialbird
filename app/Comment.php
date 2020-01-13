<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function post()
    {
    	return $this->belongsTo('App\Post');
    }

     public  function user()
    {
    	return $this->belongsTo('App\User');
    }

      public function getCreatedAtAttribute($date)
    {
        //return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d M,y h:i A');
        return Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
    }
}
