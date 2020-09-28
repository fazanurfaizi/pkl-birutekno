<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangeDetailsRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    public function me(Request $request) {
        return new UserResource($request->user());
    }

    public function changePassword(ChangePasswordRequest $request) {
        $user = User::findOrFail(Auth::user()->id);

        if(!Hash::check($request->oldPassword, $user->password)) {
            return response()->json([
                'message' => 'New password cannot be the same with old password'
            ]);
        }

        $user->password = Hash::make($request->newPassword);

        if(!$user->save()) {
            return response()->json([
                'message' => 'Opps something went wrong'
            ], 500);
        }

        return response()->json([
            'message' => 'Change password successfully'
        ]);
    }

    public function changeDetails(ChangeDetailsRequest $request) {
        $user = User::findOrFail(Auth::user()->id);
        $user->fullname = $request->fullname;
        
        return response()->json([
            'message' => 'Update profile succesfully'
        ]);
    }
}
