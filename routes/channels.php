<?php

use App\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

 
 
/*Broadcast::channel('message.{id}', function ($user, $id) {
    return auth()->user()->id ==(int) $id;
});
*/
Broadcast::channel('message.{id}', function ($user, $id) {
     return $user->id== $id;
});

Broadcast::channel('notifying.{id}', function ($user, $id) {
     return $user->id== $id;
});