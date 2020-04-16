<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class EntityController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // public function my_entity(Request $request) {
    //     $entity = $request->user()->entity;
    //     return response()->json(['status' => 'success']);
    // }

    public function leaderboard(Request $request) {
        $users = User::join('entities', 'users.id', '=', 'entities.user_id')->select('users.name', 'users.research_points', 'entities.level', 'entities.exp')->orderBy('entities.level', 'DESC')->limit(100)->get();
        return response()->json($users);
    }
}
