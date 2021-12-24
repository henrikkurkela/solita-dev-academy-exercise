<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Farm;

class ApiFarmController extends Controller
{
    public function index(Request $request)
    {
        return Farm::where('user_id', auth()->id())->get();
    }

    public function getFarm(Request $request, $id) {

        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'sensor' => [
                'nullable',
                Rule::in(['temperature', 'pH', 'rainFall'])
            ]
        ]);
    
        $location = Farm::where([
            'user_id' => auth()->id(),
            'id' => $id
        ])->firstOrFail();
    
        $dataPoints = $location->datapoints();
    
        if(isset($request->from)) {
            $dataPoints = $dataPoints->whereDate('datetime', '>=', date($request->from));   
        }
    
        if(isset($request->to)) {
            $dataPoints = $dataPoints->whereDate('datetime', '<=', date($request->to));
        }
    
        $dataPoints = $dataPoints->where('sensortype', $request->sensor ?? 'temperature')->latest('datetime')->get(['sensorType', 'value', 'datetime'])->toArray();
    
        $current = (object)[];
    
        $current->temperature = $location->dataPoints()->where('sensortype', 'temperature')->latest('datetime')->first();
        $current->pH = $location->dataPoints()->where('sensortype', 'pH')->latest('datetime')->first();
        $current->rainFall = $location->dataPoints()->where('sensortype', 'rainFall')->latest('datetime')->first();
    
        $location->current = $current;
        $location->datapoints = $dataPoints;
    
        return $location;
    }
}
