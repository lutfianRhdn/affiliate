<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $casts = [
        'id' => 'integer',
        'province_id' => 'integer',
        'city_lat' => 'float',
        'city_lon' => 'float',
    ];

    protected $primaryKey = 'id';
    
    public function province()
    {
        return $this->belongsTo('App\Model\Province','province_id');
    }

    public function getCity($province_id, $term)
    {
        $cities = City::select('id','city_name_full')
            ->where('city_name_full', 'LIKE', '%'.$term.'%')
            ->where('province_id', $province_id)
            ->orderBy('id')
            ->groupBy('id','city_name_full')->get();
        
        return $cities;
    }
}
