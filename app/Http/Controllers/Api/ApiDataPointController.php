<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Farm;
use App\Models\DataPoint;

class ApiDataPointController extends Controller
{
    public function addDataPoint(Request $request, $id) {
        $request->validate([
            'value' => 'numeric',
            'datetime' => 'date',
            'sensortype' => Rule::in(['temperature', 'pH', 'rainFall'])
        ]);
        
        try {
            $location = Farm::where([
                'id' => $id,
                'user_id' => auth()->id()
            ])->firstOrFail();
    
            $datapoint = DataPoint::createWithValidation((object)[
                'farm_id' => $location->id,
                'datetime' => $request->datetime,
                'sensortype' => $request->sensortype,
                'value' => $request->value
            ]);
    
            return $datapoint;
        } catch (\Exception $error) {
            return response()->json($error->getMessage(), 500);
        }
    }
}
