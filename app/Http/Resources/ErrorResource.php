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
                // return(str_replace('-'.$this->hash,'',$key));
                $text= $error[$key][0];
                // return $text['message'];
                $text['message']=str_replace('-'.strtolower( preg_replace('/(?<!\ )[A-Z]/', ' $0', $this->hash)),'',$text['message']);
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
