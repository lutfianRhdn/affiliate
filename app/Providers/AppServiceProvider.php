<?php

namespace App\Providers;

use App\Http\Resources\ErrorResource;
use Carbon\Carbon;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ErrorResource::withoutWrapping();
        Carbon::setlocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}
