<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

                'id' =>$this->id,
                'ProvinceName'=> $this->province_name,
                'ProvinceNameAbbr'=> $this->province_name,
                'ProvinceNameID'=> $this->province_name_id,
                'ProvinceNameEN'=> $this->province_name_en,
                'IsoCode'=> $this->iso_code,
                'IsoName'=> $this->iso_name,
                'ProvinceCapitalCityId'=> $this->province_capital_city_id,
        ];
    }
}
