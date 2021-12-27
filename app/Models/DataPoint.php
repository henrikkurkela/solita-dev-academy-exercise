<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPoint extends Model
{
    protected $fillable = ['farm_id', 'datetime', 'sensortype', 'value'];

    use HasFactory;

    public static function createWithValidation($datapoint)
    {
        try {
            $farm_id = $datapoint->farm_id;
            $datetime = date_create($datapoint->datetime);

            $lowerLimit = 0;
            $upperLimit = 0;

            switch($datapoint->sensortype)
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

            if ($datapoint->value >= $lowerLimit && $datapoint->value <= $upperLimit) {
                $value = $datapoint->value;
            } else {
                throw new \Exception('Metric value out of bounds.');
            }

            return DataPoint::create([
                'farm_id' => $farm_id,
                'datetime' => $datetime,
                'sensortype' => $sensortype,
                'value' => $value
            ]);
        } catch (\Exception $error) {
            throw new \Exception($error->getMessage());
        }
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}
