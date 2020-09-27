<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    
    public function login(LoginRequest $request) {        
        $passportRequest = $this->loginAction($request->all());
        $tokenContent = $passportRequest["content"];

        if (!empty($tokenContent['access_token'])) {
            return $passportRequest["response"];
        }

        if (empty($tokenContent)) {
            return response()->json([
                'message' => 'Email is not verified'
            ]);
        }

        return response()->json([
            'message' => 'Unauthenticated'
        ]);        
    }

    public function register(RegisterRequest $request) {
        $user = $this->registerAction($request->all());

        if(!$user) {
            return response()->json([                
                'message' => 'Registration failed'
            ], 500);
        } 

        return response()->json([
            'message' => 'Registration successed'
        ]);
    }

    public function logout() {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
            'message' => 'Logged Successfully'
        ]);
    }

    private function loginAction($request) {
        $user = User::where('username', $request['username'])
            ->orWhere('email', $request['username'])
            ->where('email_verified_at', '<>', NULL)->first();

        if (!$user) {
            return [
                "response" => 'Email is not verified',
                "content" => ''
            ];
        }

        $passwordGrantClient = Client::where('password_client', 1)->first();

        $data = [
            'grant_type' => 'password',
            'client_id' => $passwordGrantClient->id,
            'client_secret' => $passwordGrantClient->secret,
            'username' => $request['username'],
            'password' => $request['password'],
            'scope' => '*'
        ];

        $tokenRequest = Request::create('/oauth/token', 'post', $data);

        $tokenResponse = app()->handle($tokenRequest);
        $contentString = $tokenResponse->content();

        return [
            "response" => $tokenResponse,
            "content" => json_decode($contentString, true)
        ];
    }

    private function registerAction($request) {
        $clientRole = Role::client()->first();

        $user = User::create([
            'username' => $request['username'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        $user->roles()->attach($clientRole->id);

        $user->sendEmailVerificationNotification();

        return $user;
    }

}
