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
        $request->validate([
            'location' => 'required|unique:farms'
        ]);

        $location = Farm::firstOrCreate([
            'location' => $request->location,
            'user_id' => auth()->id()
        ]);

        return redirect('dashboard')->with('success', "Location $location->location created successfully.");
    }

    public function getFarm(Request $request, $id)
    {
        try {
            $location = Farm::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])->firstOrFail();

            $temperatures = $location->dataPoints()->where('sensortype', 'temperature')->get(['value AS y', 'datetime as x'])->toArray();
            $phs = $location->dataPoints()->where('sensortype', 'pH')->get(['value AS y', 'datetime as x'])->toArray();
            $rainfalls = $location->dataPoints()->where('sensortype', 'rainFall')->get(['value AS y', 'datetime as x'])->toArray();

            return view('location', [
                'success' => "Location $location->location opened successfully.",
                'temperatures' => $temperatures,
                'phs' => $phs,
                'rainfalls' => $rainfalls,
                'location' => $location
            ]);

        } catch (\Exception $error) {
            return redirect('dashboard')->withErrors($error->getMessage());
        }
    }

    public function getFarmTable(Request $request, $id, $sensor)
    {
        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'pagination' => 'nullable|numeric'
        ]);

        try {
            $location = Farm::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])->firstOrFail();

            $measurements = $location->dataPoints()->count();
            $dataPoints =$location->dataPoints();

            if(isset($request->from)) {
                $dataPoints = $dataPoints->whereDate('datetime', '>=', date($request->from));   
            }

            if(isset($request->to)) {
                $dataPoints = $dataPoints->whereDate('datetime', '<=', date($request->to));
            }
            
            switch($sensor) {
                case 'temperature':
                    $dataPoints = $dataPoints->where('sensortype', 'temperature')->orderByDesc('datetime');
                    break;
                case 'pH':
                    $dataPoints = $dataPoints->where('sensortype', 'pH')->orderByDesc('datetime');
                    break;
                case 'rainFall':
                    $dataPoints = $dataPoints->where('sensortype', 'rainFall')->orderByDesc('datetime');
                    break;
                default:
                    $dataPoints = $dataPoints->orderByDesc('datetime');
            }

            if (isset($request->pagination)) {
                switch($request->pagination) {
                    case '10':
                        $dataPoints = $dataPoints->paginate(10);
                        break;
                    case '25':
                        $dataPoints = $dataPoints->paginate(25);
                        break;
                    case '100':
                    default:
                        $dataPoints = $dataPoints->paginate(100);
                        break;
                }
            } else {
                $dataPoints = $dataPoints->paginate(100);
            }

            return view('location.table', [
                'success' => $measurements . " recorded measurement points for this location.",
                'dataPoints' => $dataPoints,
                'location' => $location,
                'from' => $request->from ?? '',
                'to' => $request->to ?? '',
                'pagination' => $request->pagination ?? ''
            ]);
        } catch (\Exception $error) {
            return redirect('dashboard')->withErrors($error->getMessage());
        }
    }

    public function removeFarm(Request $request, $id)
    {
        try {
            $location = Farm::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])->firstOrFail();

            $location->delete();

            return redirect('dashboard')->with('success', "Location $location->location removed successfully.");
        } catch (\Exception $error) {
            return redirect('dashboard')->withErrors("Error encountered while removing location, try again later.");
        }
    }

    public function removeAllFarms()
    {
        Farm::select('*')->delete();

        return redirect('dashboard')->with('success', "All measurement and location data removed successfully");
    }
}
