<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema; //Import Schema
use Illuminate\Support\ServiceProvider;
use Braintree_Configuration;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Braintree_Configuration::environment(env('BRAINTREE_ENV'));
        Braintree_Configuration::merchantId(env('BRAINTREE_MERCHANT_ID'));
        Braintree_Configuration::publicKey(env('BRAINTREE_PUBLIC_KEY'));
        Braintree_Configuration::privateKey(env('BRAINTREE_PRIVATE_KEY'));
        Schema::defaultStringLength(191); //Solved by increasing StringLength
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
