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
            'location' => $request->location
        ]);

        return view('location.add', ['location' => $location]);
    }

    public function removeAllFarms()
    {
        Farm::select('*')->delete();

        return view('location.removeall');
    }
}
