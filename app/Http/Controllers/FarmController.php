<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Farm;

class FarmController extends Controller
{
    public function addFarm(Request $request)
    {
        $location = Farm::firstOrCreate([
            'location' => $request->location,
            'user_id' => auth()->id()
        ]);

        return view('dashboard')->with(['message' => "Location $location->location created successfully."]);
    }

    public function removeAllFarms()
    {
        Farm::select('*')->delete();

        return view('dashboard')->with(['message' => "All measurement and location data removed successfully"]);
    }
}
