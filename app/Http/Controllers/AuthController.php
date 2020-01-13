<?php

namespace App\Http\Controllers;

use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
 
    public function login(Request $request)
    {
    	$request->request->add([
    		'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'p7buyTJzoidNiwXSkCpumnvhAg4T5Uhkfl47mhm6',
            'username' => $request->username,
            'password' => $request->password,
    	]);

    	$tokenRequest = Request::create(env('APP_URL') . '/oauth/token','post');

    	$response=Route::dispatch($tokenRequest);

    	return $response;
    }

    public function register(Request $request)
    {
         $request->validate( [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user= User::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'username' => $request['firstname'].$request['lastname'].mt_rand(1000,9999),
            'password' => Hash::make($request['password']),
            'userinfo' => $this->randomAvatar(),
        ]);

        UserMeta::create([
            "user_id" => $user->id,
            "title"    => "TheSquad.Space User",
            "social"    => json_encode(["facebook" => "","twitter" => "","instagram" => ""])
        ]);

        return $user;
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token,$key)
        {
            $token->delete();
        });

        return response()->json('Logged out successfully',200);
    }

    public function randomAvatar(){
        $avatarClass=["primary "," success "," warning "," danger "," info "," light "," dark "," red "," green "," pink "," purple "," violet "," indigo "," blue "," sky "," cyan "," teal "," neon "," lime "," sun "," yellow "," orange "," pumpkin "," brown "," grey "," gold "];
            $randomClass=array_rand($avatarClass);
            $avatar= trim($avatarClass[$randomClass]);

            switch ($avatar) {
                case 'primary':
                    $background="primary";
                    break;
                case 'success':
                    $background="success";
                    break;
                case 'primary':
                    $background="primary";
                    break;
                case 'warning':
                    $background="warning";
                    break;
                case 'danger':
                    $background="danger";
                    break;
                case 'info':
                    $background="info";
                    break;
                case 'light':
                    $background="dark";
                    break;
                case 'dark':
                    $background="light";
                    break;
                case 'red':
                    $background="pony";
                    break;
                case 'green':
                    $background="heaven";
                    break;
                case 'pink':
                    $background="space";
                    break;
                case 'purple':
                    $background="streaks";
                    break;
                case 'violet':
                    $background="bunting";
                    break;
                case 'indigo':
                    $background="paradise";
                    break;
                case 'blue':
                    $background="info";
                    break;
                case 'sky':
                    $background="heaven";
                    break;
                case 'cyan':
                    $background="streaks";
                    break;
                case 'teal':
                    $background="sunset";
                    break;
                case 'neon':
                    $background="paradise";
                    break;
                case 'lime':
                    $background="success";
                    break;
                case 'sun':
                    $background="metal";
                    break;
                case 'yellow':
                    $background="warbler";
                    break;
                case 'orange':
                    $background="honey";
                    break;
                case 'pumpkin':
                    $background="dusk";
                    break;
                case 'brown':
                    $background="metal";
                    break;
                case 'grey':
                    $background="ashes";
                    break;
                case 'gold':
                    $background="royston";
                    break;
                default:
                    $background="ashes";
                    break;
            }

            return json_encode(["avatar" => $avatar,"background" => $background]);
    }
}
