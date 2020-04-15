<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function my_entity(Request $request) {
        $entity = $request->user()->entity;
        return response()->json(['status' => 'success', 'level' => $entity->level, 'exp' => $entity->exp, 'max_exp' => round(max_exp() * 0.66)]);
    }
}
