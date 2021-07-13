<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Commission;
use App\Models\Product;
use App\Models\User;
use App\Notifications\GenerateInvoiceNotification;
use App\Notifications\ComplatePaymentInvoiceNotification;
use Carbon\Carbon;

class CalculateCommission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $product;
    protected $reseller;
    protected $total;
    public $response;
    public function __construct($product, $user, $total){
        $this->product = $product;
        $this->reseller = $user;
        $this->total= $total;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {

        $commission = Commission::create([
            'user_id'=>$this->reseller->id,
            'product_id'=>$this->product->id,
            'total_payment'=>$this->total,
            'percentage'=>$this->product->setting->where('key','percentage')->first()->value,
            'total_commission'=>$this->total*($this->product->setting->where('key','percentage')->first()->value /100),
            'company_id'=>$this->product->company->id
        ]);  
        $this->reseller->notify(new GenerateInvoiceNotification($commission));
        foreach($this->product->company->users as $user){
           if($user->hasRole('super-admin-company')|| $user->hasRole('admin')){
                $user->notify(new ComplatePaymentInvoiceNotification($commission));
            }
        }
    }
        public function getResponse()
        {
            return $this->response;
        }
       
}


