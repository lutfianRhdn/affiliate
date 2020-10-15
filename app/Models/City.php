<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $casts = [
        'city_id' => 'integer',
        'province_id' => 'integer',
        'city_lat' => 'float',
        'city_lon' => 'float',
    ];

    protected $primaryKey = 'city_id';
    
    public function province()
    {
        return $this->belongsTo('App\Model\Province','province_id');
    }
}
