<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $preserveKeys = true;

    public function toArray($request)
    {
        return [
                'id'=>$this->id,
                'text'=>$this->city_name,
            // 'profince_id'=>$this->province_id,
            // 'city_name_full'=>$this->city_name_full,
            // 'city_type'=>$this->city_type
        ];
    }
}
