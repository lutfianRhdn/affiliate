<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\ProvinceTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Province Model.
 */
class Province extends Model
{
    public $timestamps = false;
    
    protected $casts = [
        'id' => 'integer',
        'province_lat' => 'float',
        'province_lon' => 'float',
        'province_capital_city_id' => 'integer',
        'timezone' => 'integer',
    ];

    protected $primaryKey = 'id';
    
    // public function cities()
    // {
    //     return $this->hasMany('App\Model\City','province_id');
    // }
    
    // public function getData()
    // {
    //     $provinces = Province::select('id','province_name')->orderBy('province_name')->get();
    //     return $provinces;
    // }
}
