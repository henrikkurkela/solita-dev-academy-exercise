<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    protected $fillable = ['location', 'user_id'];

    use HasFactory;

    public function dataPoints()
    {
        return $this->hasMany(DataPoint::class);
    }
}
