<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->bind(
        	\App\Services\Order\Contracts\OrderContract::class,
            \App\Services\Order\Order::class
        );
    }

}
