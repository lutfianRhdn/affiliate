<?php

namespace App\Console\Commands;

use App\Jobs\CalculateCommission as JobsCalculateCommission;
use App\Models\Commission;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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
            // \Log::info($setting);
            if ($now->format('d') == $setting->value) {
                $resellers = $product->users;
                foreach ($resellers as $reseller ) {
                    $commissions = Commission::where('user_id',$reseller->id)->whereYear('created_at',$now->format('Y'));
                    $total =0;
                    foreach ($reseller->clients as $client) {
                        $transactions = $client->transactions;
                        // $this->info($transactions->count());
                        if ($commissions->count() >0) {
                            $transactions = $client->transactions->where('payment_date','>',$commissions->latest('id')->first()->created_at);
                        }
                            foreach ($transactions as $transaction ) {
                                if (Carbon::parse($transaction->payment_date)->format('m-Y') == $now->format('m-Y')) {
                                    $total += $transaction->total_payment;
                                }
                            }
                        }
                        $this->calculate($product,$reseller,$total);
                }
            }
        }
    }
    public function calculate($product,$reseller,$total)
    {
        $now = Carbon::now();
        $commissions = Commission::where('user_id',$reseller->id)->whereYear('created_at',$now->format('Y'))->whereMonth('created_at',$now->format('m'))->get()->count() ;
        if ($commissions== 0) {
            $job = new JobsCalculateCommission($product,$reseller,$total,$commissions);
            $data = dispatch($job);
            Storage::append('log.txt','data ===== '.json_encode($data));
        } 
    }
}
