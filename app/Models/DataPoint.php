<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPoint extends Model
{
    protected $fillable = ['farm_id', 'datetime', 'sensortype', 'value'];

    use HasFactory;

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}
