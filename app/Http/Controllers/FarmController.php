<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Farm;
use App\Models\DataPoint;

class FarmController extends Controller
{
    public function addFarm(Request $request)
    {
        $location = Farm::firstOrCreate([
            'location' => $request->location,
            'user_id' => auth()->id()
        ]);

        return redirect('dashboard')->with('success', "Location $location->location created successfully.");
    }

    public function getFarm(Request $request)
    {
        try {
            $location = Farm::where([
                'id' => $request->id,
                'user_id' => auth()->id()
            ])->firstOrFail();

            $dataPoints = $location->dataPoints()->count();

            return redirect('dashboard')->with('success', "Location $location->location opened successfully. " . $dataPoints . " measurement points stored for this location.");
        } catch (\Exception $error) {
            return redirect('dashboard')->with('error', "Error encountered while opening location, try again later.");
        }
    }

    public function removeFarm(Request $request)
    {
        try {
            $location = Farm::where([
                'id' => $request->id,
                'user_id' => auth()->id()
            ])->firstOrFail();

            $location->delete();

            return redirect('dashboard')->with('success', "Location $location->location removed successfully.");
        } catch (\Exception $error) {
            return redirect('dashboard')->with('error', "Error encountered while removing location, try again later.");
        }
    }

    public function removeAllFarms()
    {
        Farm::select('*')->delete();

        return redirect('dashboard')->with('success', "All measurement and location data removed successfully");
    }
}
