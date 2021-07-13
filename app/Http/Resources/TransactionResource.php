<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return strtotime($this->transactions->last()->payment_date);
        return [
            'name'=>$this->name,
            'unic_code'=>$this->unic_code,
            'transaction'=>[
                'total_payment'=>$this->transactions->last()->total_payment,
                'payment_date'=> date('d-M-Y',strtotime($this->transactions->last()->payment_date)),
                'total_transaction'=>$this->transactions->count()
            ]
        ];
    }
}
