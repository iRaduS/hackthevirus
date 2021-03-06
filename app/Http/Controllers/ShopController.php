<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Costume;
use App\EntityCostume;

class ShopController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function shop(Request $request) {
        return response()->json(Costume::all());
    }

    public function shop_buy($id, Request $request) {
        $costume = Costume::find($id);
        $logs = EntityCostume::where(['costume_id' => $costume->id, 'entity_id' => $request->user()->id])->first();

        if ($request->user()->research_points < $costume->costume_price) return response()->json(['status' => 'error', 'message' => 'You do not have enough Research Points.']);
        if ($logs) return response()->json(['status' => 'error', 'message' => 'You have already bought this item.']);

        if ($costume->id !== 4) EntityCostume::create(['entity_id' => $request->user()->entity->id, 'costume_id' => $costume->id]);
        
        $request->user()->research_points -= $costume->costume_price;
        $request->user()->save();

        if ($costume->id === 4) $request->user()->entity->level++;
        $request->user()->entity->save();

        return response()->json(['status' => 'success', 'message' => 'You have purchased with success this item.']);
    }

    public function my_costumes(Request $request) {
        $logs = EntityCostume::where(['entity_id' => $request->user()->entity->id])->get();
        return response()->json($logs);
    }
}