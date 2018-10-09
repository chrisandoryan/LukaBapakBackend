<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Mail\EmailActivation;
use App\VerifyUser;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class AuthController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'activateAccount', 'me', 'inviteAdmin']]);
    }

    public function inviteAdmin(Request $request) {
            // dd($request->email);
            $user = User::where('email', $request->email)->first();
            // dd($user->email);
            $verifyUser = VerifyUser::create([
                'user_uuid' => $user->uuid,
                'token' => str_random(40),
            ]);
        Mail::to($request->email)->send(new EmailActivation($user));
    }

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

        // $verifyUser = VerifyUser::create([
        //     'user_uuid' => $user->uuid,
        //     'token' => str_random(40),
        // ]);

        // Mail::to($user->email)->send(new EmailActivation($user));

        return $user;

    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        // dd($credentials);
        // $user = User::where('email', $request->email)->where('password', bcrypt($request->password))->first();
        if ($request->mode == "phone") {
            $user = User::where('phone', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'Invalid email or password']);
            }
            else if (Hash::check($request->password, $user->password)) {
                $credentials = ['email' => $user->email, 'password' => $request->password];
            }
        }
        else if ($request->mode == "email") {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['message' => 'Invalid email or password']);    
            }
        }
        else if ($request->mode == "username") {
            $user = User::where('username', $request->email)->first();
            if ($user == null) {
                return response()->json(['message' => 'Invalid email or password']);
            }
            else if (Hash::check($request->password, $user->password)) {
                $credentials = ['email' => $user->email, 'password' => $request->password];
            }
        }
        // dd($credentials);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password']);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function activateAccount($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->is_admin) {
                $verifyUser->user->is_admin = 1;
                $verifyUser->user->save();
                $status = "You are now Admin.";
            } else {
                $status = "You already are an Admin.";
            }
        } else {
            $status = "Sorry your email cannot be identified.";
        }

        return $status;
    }

    public function meFromToken()
    {
        try {
            $user = auth()->userOrFail();
            return response()->json($user);
        } catch (MethodNotAllowedHttpException $e) {
            return response()->json($e);
        }
    }
}
