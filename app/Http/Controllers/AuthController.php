<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Entity;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->only(['name', 'email', 'password']), [
            'name' => 'required|alpha_num|string|min:4|max:12',
            'email' => 'required|string|email|unique:users|min:6|max:64',
            'password' => 'required|string|min:6|max:32'
        ]);

        if ($validator->fails()) return response()->json(['status' => 'error', 'message' => 'There are some fields invalid check your password, username and email.']);
        
        $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => $request->password, 'api_key' => bin2hex(random_bytes(64)), 'safe_lat' => floatval($request->safe_lat), 'safe_long' => floatval($request->safe_long)]);
        Entity::create(['user_id' => $user->id]);

        return response()->json(['status' => 'success', 'api_key' => $user->api_key]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|string|email|exists:users|min:6|max:64',
            'password' => 'required|string|min:6|max:32'
        ]);
        
        if ($validator->fails()) return response()->json(['status' => 'error', 'message' => 'There are some fields invalid check your password and email.']);

        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) return response()->json(['status' => 'error', 'message' => 'The password you have entered for this email is not valid.']);
        
        $user->api_key = bin2hex(random_bytes(64));
        $user->save();
        return response()->json(['status' => 'success', 'api_key' => $user->api_key]);
    }

    public function my_user(Request $request) {
        $entity = $request->user()->entity;
        return response()->json(['status' => 'success', 'name' => $request->user()->name, 'email' => $request->user()->email, 'level' => $entity->level, 'exp' => $entity->exp, 'max_exp' => round(max_exp() * 0.66), 'research_points' => $request->user()->research_points, 'distance' => $request->user()->distance]);
    }
}
