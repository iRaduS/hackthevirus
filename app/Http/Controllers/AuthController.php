<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $this->validate($request, [
            'name' => 'required|alpha_num|string|min:4|max:32',
            'email' => 'required|string|email|unique:users|min:6|max:64',
            'password' => 'required|string|confirmed|min:6|max:32',
            'password_confirmation' => 'required|string|min:6|max:32'
        ]);
        
        $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => $request->password, 'api_key' => bin2hex(random_bytes(64))]);
        return response()->json(['status' => 'success', 'api_key' => $user->api_key]);
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|string|email|exists:users|min:6|max:64',
            'password' => 'required|string|min:6|max:32'
        ]);
        
        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) return response()->json(['status' => 'error', 'message' => 'The password you have entered for this email is not valid.']);
        
        $user->api_key = bin2hex(random_bytes(64));
        $user->save();
        return response()->json(['status' => 'success', 'api_key' => $user->api_key]);
    }

    public function my_user(Request $request) {
        return response()->json(['status' => 'success', 'user' => $request->user()]);
    }
}
