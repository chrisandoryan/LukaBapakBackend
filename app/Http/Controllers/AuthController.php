<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Mail\EmailActivation;
use App\VerifyUser;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:new_users',
            'username' => 'required|unique:new_users',
            'password' => 'required',
            'gender' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Duplicated data'], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        // uncomment below for auto login after registering
        // $token = auth()->login($user);

        // return $this->respondWithToken($token, $user);

        $verifyUser = VerifyUser::create([
            'user_uuid' => $user->uuid,
            'token' => str_random(40),
        ]);

        Mail::to($user->email)->send(new EmailActivation($user));

        return $user;

    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $user = User::where('email', $request->email)->first();

        if (!$user->verified) {
            return response()->json(['message' => 'Please activate your account first']);
        }

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password']);
        }

        return $this->respondWithToken($token, $user);
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function activateAccount()
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            $status = "Sorry your email cannot be identified.";
        }

        return $status;
    }
}
