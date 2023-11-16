<?php

namespace App\Providers;

use App\Services\Starwars\SwCharcterFeilds;
use App\Services\Starwars\SwCharctersApi;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Starwars\swcharctersprovider;

class ExternalDataProvidersProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(swcharctersprovider::class, function ($app) {
            return match (config('external-apis.swapiprovider')) {
                'sw_api_live_provider' => new SwCharctersApi(config('external-apis.sw_api_live_provider')),
                'sw_api_test_provider' => new SwCharctersApi(config('external-apis.sw_api_test_provider')),
            };

        });
        $this->app->bind(SwCharcterFeilds::class);
    }

}