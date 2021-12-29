<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Farm;
use App\Models\DataPoint;

class ApiDataPointController extends Controller
{
    /**
     * @urlParam id integer required The ID of the location.
     * @bodyParam sensortype string required The sensortype of the measurement.
     * @bodyParam datetime string required The date and time of the measurement.
     * @bodyParam value string required The measurement value.
     */
    public function addDataPoint(Request $request, $id)
    {
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
