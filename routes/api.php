<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// User
Broadcast::routes(['middleware' => 'auth:api']);
//Route::post('/broadcasting/auth',["uses" => "Api\BroadcastAuthController@auth","middleware" => "auth:api"]);
Route::post('/user',["uses" => "UserController@user","middleware" => "auth:api"]);
Route::get('/user/{username}',["uses" => "UserController@getUserByUsername","middleware" => "auth:api"]);
Route::post('/user/{username}/update',["uses" => "UserController@update","middleware" => "auth:api"]);
Route::post('/user/validate',["uses" => "UserController@validateUserByUsername","middleware" => "auth:api"]);
Route::post('/user/update.background',["uses" => "UserController@updateBackground","middleware" => "auth:api"]);
Route::post('/user/update.image',["uses" => "UserController@updateImage","middleware" => "auth:api"]);
Route::post('/user.startinfo',["uses" => "UserController@start","middleware" => "auth:api"]);
// User Image Routes
Route::post('/user.images',["uses" => "UserController@images","middleware" => "auth:api"]);
//new
Route::post('/getuser',["uses" => "UserController@getUser","middleware" => "auth:api"]);
Route::post('/setuser',["uses" => "UserController@setUser","middleware" => "auth:api"]);

// Auth 
Route::post('/login',["uses" => "AuthController@login","name" => "login"]);
Route::post('/register',["uses" => "AuthController@register","name" => "login"]);
Route::post('/logout',["uses" => "AuthController@logout","middleware" => "auth:api"]);

// post routes
Route::post('/post.compose',["uses" => "PostController@create","middleware" => "auth:api"]);
Route::post('/post.compose.v2',["uses" => "PostController@createV2","middleware" => "auth:api"]);
Route::post('/post.feed',["uses" => "PostController@feed","middleware" => "auth:api"]);
Route::post('/posts.{username}',["uses" => "PostController@userPosts","middleware" => "auth:api"]);
Route::post('/post.single',["uses" => "PostController@post","middleware" => "auth:api"]);
Route::post('/post.delete',["uses" => "PostController@delete","middleware" => "auth:api"]);
Route::post('/post.update',["uses" => "PostController@update","middleware" => "auth:api"]);
//post reacts
Route::post('/post.reacts',["uses" => "PostController@reactionsList","middleware" => "auth:api"]);
// comment routes
Route::post('/comment.compose',["uses" => "CommentController@create","middleware" => "auth:api"]);
Route::post('/comment.edit',["uses" => "CommentController@edit","middleware" => "auth:api"]);
Route::post('/comment.fetch',["uses" => "CommentController@fetch","middleware" => "auth:api"]);
Route::post('/comment.fetch2',["uses" => "CommentController@fetch2","middleware" => "auth:api"]);
Route::post('/comment.delete',["uses" => "CommentController@delete","middleware" => "auth:api"]);
// react route
Route::post('/react',["uses" => "ReactController@react","middleware" => "auth:api"]);
// follow route
Route::post('/follow',["uses" => "FollowController@follow","middleware" => "auth:api"]);
Route::post('/follow.suggestions',["uses" => "FollowController@followSuggestion","middleware" => "auth:api"]);
Route::post('/follower.list',["uses" => "FollowController@followerList","middleware" => "auth:api"]);
Route::post('/following.list',["uses" => "FollowController@followingList","middleware" => "auth:api"]);
//Chat
Route::post('/chat.heads',["uses" => "ChatController@ChatHeads","middleware" => "auth:api"]);
Route::post('/chat.conversation',["uses" => "ChatController@conversations","middleware" => "auth:api"]);
Route::post('/chat.send',["uses" => "ChatController@sendMessage","middleware" => "auth:api"]);
//Activity
Route::get('/activity.{username}',["uses" => "UserController@activity","middleware" => "auth:api"]);
//Notification
Route::post('/notification.read',["uses" => "UserController@readNotification","middleware" => "auth:api"]);
//Search
Route::post('/search',["uses" => "UserController@search","middleware" => "auth:api"]);
//Feedback
Route::post('/feedback.submit',["uses" => "UserController@feedback","middleware" => "auth:api"]);
//test
Route::get('u/{username}',["uses" => "UserController@userProfile","middleware" => "auth:api"]);