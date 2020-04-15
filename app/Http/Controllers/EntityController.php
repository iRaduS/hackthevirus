<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function my_entity(Request $request) {
        return response()->json(['status' => 'success', 'entity' => $request->user()->entity]);
    }
}
