<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity;

class EntityController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function my_entity(Request $request) {
        return response()->json(['status' => 'success', 'entity' => Entity::where('user_id', $request->user()->id)->first()]);
    }
}
