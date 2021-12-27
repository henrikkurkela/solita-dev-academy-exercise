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
        $startTime = microtime(true);
        $rows = explode("\n", $request->file->get());
        $acceptedRows = 0;
        $rejectedRows = 0;

        $farms = Farm::where('user_id', auth()->id())->get();
        $locations = $farms->map(function ($item, $key) {
            return $item->location;
        })->toArray();

        foreach ($rows as $row) {
            try {
                $fields = explode(",", $row);
                $datapoint = (object)[];

                if (in_array($fields[0], $locations)) {
                    $datapoint->farm_id = $farms->firstWhere('location', $fields[0])->id;
                    $datapoint->datetime = $fields[1];
                    $datapoint->sensortype = $fields[2];
                    $datapoint->value = $fields[3];
                } else {
                    throw new \Exception('Unfamiliar farm name.');
                }

                if (DataPoint::createWithValidation($datapoint)) {
                    $acceptedRows += 1;
                } else {
                    $rejectedRows += 1;
                }
            } catch (\Exception $error) {
                $rejectedRows += 1;
            }
        }

        $runtime = microtime(true) - $startTime;

        return redirect('dashboard')->with('success', "Processed a total of " . count($rows) . " rows in $runtime seconds. $acceptedRows measurements were accepted, $rejectedRows measurements were rejected.");
    }
}
