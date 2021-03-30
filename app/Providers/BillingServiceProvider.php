<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class BillingServiceProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->bind(
            \App\Services\Billing\Contracts\BillingContract::class,
            \App\Services\Billing\Culqi::class
        );
    }

}
