<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Farm;
use App\Models\DataPoint;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $rows = explode("\n", $request->file->get());
        $acceptedRows = 0;
        $declinedRows = 0;
        foreach ($rows as $row)
        {
            $fields = explode(",", $row);
            try {
                $location = $fields[0];

                $farm = Farm::where('location', $location)->firstOr(function () {
                    throw new \Exception('Unfamiliar farm name.');
                });

                $datetime = date_create($fields[1]);

                $sensortype = '';
                $lowerLimit = 0;
                $upperLimit = 0;

                switch($fields[2])
                {
                    case 'pH':
                        $sensortype = 'pH';
                        $lowerLimit = 0.0;
                        $upperLimit = 14.0;
                        break;
                    case 'rainFall':
                        $sensortype = 'rainFall';
                        $lowerLimit = 0.0;
                        $upperLimit = 500.0;
                        break;
                    case 'temperature':
                        $sensortype = 'temperature';
                        $lowerLimit = -50.0;
                        $upperLimit = 100.0;
                        break;
                    default:
                        throw new \Exception('Unsupported sensor type.');
                }

                $value = 0;

                if ($fields[3] >= $lowerLimit && $fields[3] <= $upperLimit) {
                    $value = $fields[3];
                } else {
                    throw new \Exception('Metric value out of bounds.');
                }

                $measurement = DataPoint::firstOrCreate([
                    'farm_id' => $farm->id,
                    'datetime' => $datetime,
                    'sensortype' => $sensortype,
                    'value' => $value
                ]);

                $acceptedRows = $acceptedRows + 1;
            } catch (\Exception $error) {
                $declinedRows = $declinedRows + 1;
            }
        }
        return redirect('dashboard')->with('success', "Processed a total of " . count($rows) . " rows. $acceptedRows measurements were accepted, $declinedRows measurements were declined.");
    }
}
