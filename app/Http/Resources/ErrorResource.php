<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $errors = [];

        foreach($this->resource as  $error){
            $keys = array_keys($error);
            $text = $error;
            foreach($keys as  $key ){
                $text= $error[$key][0];
                $errors += [$key=>$text];
            }
        }
        $collection = collect($errors);
        return [
            'status' => 'error',
            'errors'=>$collection
        ];
    }
}
