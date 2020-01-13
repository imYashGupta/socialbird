<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    //
    protected $table = 'usersmeta';
 	protected $fillable=["user_id","title",'social'];
 	protected $hidden=["ip_address"];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }


}
