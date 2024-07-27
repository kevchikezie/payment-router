<?php

namespace Kevchikezie\PaymentRouter;

use Illuminate\Support\ServiceProvider;

class PaymentRouterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/payment-router.php',
            'payment-router'
        );

        $this->app->singleton(PaymentRouter::class, function ($app) {
            $router = new PaymentRouter();

            $processors = config('payment-router.processors');
            foreach ($processors as $name => $config) {
                $class = $config['class'];
                $router->addProcessor($name, new $class($config));
            }

            return $router;
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/payment-router.php' => config_path('payment-router.php'),
        ]);
    }
}
