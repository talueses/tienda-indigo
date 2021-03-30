<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->bind(
        	\App\Services\Cart\Contracts\CartContract::class,
            \App\Services\Cart\Cart::class
        );
    }

}
