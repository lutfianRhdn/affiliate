<?php

namespace App\Console\Commands;

use App\Models\Commission;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commission:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'commission calculate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $products = Product::all();
        foreach($products as $product){
            $setting = $product->setting->where('key','day of settelment')->first();
            $now= Carbon::now();
            if ($now->format('d') == $setting->value) {
                $resellers = $product->users;
                foreach ($resellers as $reseller ) {
                    $total =0;
                    foreach ($reseller->clients as $client) {
                        foreach ($client->transactions as $transaction ) {
                            if (Carbon::parse($transaction->payment_date)->format('m-Y') == $now->format('m-Y')) {
                                $total += $transaction->total_payment;
                            }
                        }
                    }
                    Commission::create([
                        'user_id'=>$reseller->id,
                        'product_id'=>$product->id,
                        'payment'=>$total*($product->setting->where('key','percentage')->first()->value /100),
                        'company_id'=>$product->company->id
                    ]);
               }
               $this->info('the commision calculated');
           }
        }
    }
}
