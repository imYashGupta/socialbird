<?php

namespace App;

use App\Follow;
use App\UserImage;
use App\UserMeta;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    public $imageAccountPath="/images/profile/account/";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'email', 'password','image','lastname','username','userinfo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email','email_verified_at','created_at','updated_at','userinfo',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     protected $appends = ['follower','fullname',"usermeta","images","avatar","background","joinon"];

    public function getImagesAttribute()
     {  
        $profileImage=UserImage::where('user_id',$this->id) 
            ->where('type','account')
            ->where('current','1')
            ->orderBy('created_at',"DESC")
            ->first();
        if ($profileImage) {
            return $this->imageAccountPath.$profileImage->name;    
        }
        else{
            return null;
        }    

     } 

     public function getJoinonAttribute()
     {
         
         return Carbon::createFromTimeStamp(strtotime($this->created_at))->toFormattedDateString();
     }
     public function getAvatarAttribute()
     {
         $userinfo= json_decode($this->userinfo);
            return $userinfo->avatar;
     }
    public function getBackgroundAttribute()
     {
         $userinfo= json_decode($this->userinfo);
        return $userinfo->background;
     }
    public function getFollowerAttribute(){

        if (Auth::check()) {
            if ($this->id==auth()->user()->id) {
                $response=null;
            }
            else{
                $response=Follow::where('user_id',auth()->user()->id)->where('following',$this->id)->exists();
            }
        }
        else{
            $response=null;
        }
        return $response;
     }

     public function getFullnameAttribute()
     {
        return $this->firstname." ".$this->lastname;
     }


     public function getUsermetaAttribute()
     {
        $usermeta=UserMeta::where("user_id",$this->id)->first();
        if ($usermeta) {
            $data= [
                "title"     => $usermeta->title,
                "desc"      => $usermeta->description,
                "country"   => $usermeta->country,
                "city"      => $usermeta->city,
                "settings"  => $usermeta->settings,
                "social"  => json_decode( $usermeta->social),
            ];
        }
        else{
            $data= [
                "title"     => '',
                "desc"      => '',
                "country"   => '',
                "city"      => '',
                "settings"  => '',
            ];
        }

        return $data;
     }
     // public function getInfoAttribute()
     // {
     //    UserMeta::where('user_id',)
     //    return ;

     // }

     public function posts()
    {
        return $this->hasMany('App\Post');
    }

      public function comment()
    {
        return $this->hasMany('App\Comment');
    }
          public function react()
    {
        return $this->hasMany('App\React');
    }
     public function follow()
    {
        return $this->hasMany('App\Follow');
    }

    public function usermeta()
    {
        return $this->hasMany('App\UserMeta');
    }
    public static function following()
    {
       /* $users=User::where('id',function($query){
            $query->select('following')->from('follows')->where('user_id',auth()->user()->id);
        })->pluck('id')->toArray();*/
        $following=Follow::where('user_id',auth()->user()->id)->pluck('following')->toArray();

        return $following;
    }

        static function validateUsername($username)
    {
        $user=User::where('username',$username)->first();
        return $user;
    }
}
