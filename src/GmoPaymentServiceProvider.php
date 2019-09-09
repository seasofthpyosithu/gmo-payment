<?php

namespace Seasofthpyosithu\GmoPayment;

use Illuminate\Support\ServiceProvider;
use Seasofthpyosithu\GmoPayment\Remittance\RemittanceApi;

class GmoPaymentServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/gmo.php' => config_path('gmo.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('remittance-api', function() {
            return new RemittanceApi();
        });
    }
}
