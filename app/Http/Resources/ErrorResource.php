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
private $errors=[];

    public function __construct($errors,$hash)
    {
        $this->errors= $errors;
        $this->hash=$hash;
    }
    public function toArray($request)
    {
        $errors = [];

        foreach($this->errors as  $error){
            $keys = array_keys($error);
            $text = $error;
            foreach($keys as  $key ){
                $text= $error[$key][0];
                $errors += [ str_replace('-'.$this->hash,'',$key)=>$text];
            }
        }
        $collection = collect($errors);
        return [
            'status' => 'error',
            'errors'=>$collection
        ];
    }
}
