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

        return redirect('dashboard')->with('status', "Location $location->location created successfully.");
    }

    public function removeAllFarms()
    {
        Farm::select('*')->delete();

        return redirect('dashboard')->with('status', "All measurement and location data removed successfully");
    }
}
