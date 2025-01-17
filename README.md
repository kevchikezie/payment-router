# Payment Router

This Laravel package intelligently route payment transactions to the most suitable payment processor based on various factors such as transaction cost, reliability, and currency support.

## What do you need before you can use this library?

Before installing this Laravel package, ensure you have the requirements below;

- PHP >=8.2 (PHP 8.2 and above)

## How do you install this package?

Install via composer

```bash
composer require kevchikezie/payment-router
```

## How do you configure this package?

Publish the configuration file after the package is installed

```bash
php artisan vendor:publish --provider="Kevchikezie\PaymentRouter\PaymentRouterServiceProvider"
```

After running the command above, check your **config** folder, you should see a file named `payment-router.php`.
The content of this file may look like or be configured as the sample below;

```php
<?php

return [
    'processors' => [
        'flutterwave' => [
            'class' => Kevchikezie\PaymentRouter\Processors\FlutterwaveProcessor::class,
            'secret_key' => env('FLUTTERWAVE_SECRET_KEY'),
            'public_key' => env('FLUTTERWAVE_PUBLIC_KEY'),
            'supported_currencies' => ['USD', 'GBP', 'NGN', 'GHS'],
            'transaction_cost' => [
                'USD' => 1.2,
                'GBP' => 1.9,
                'NGN' => 0.25,
                'GHS' => 0.23
            ],
        ],
        'paystack' => [
            'class' => Kevchikezie\PaymentRouter\Processors\PaystackProcessor::class,
            'secret_key' => env('PAYSTACK_SECRET_KEY'),
            'public_key' => env('PAYSTACK_PUBLIC_KEY'),
            'supported_currencies' => ['NGN', 'USD', 'EUR'],
            'transaction_cost' => [
                'NGN' => 0.15,
                'USD' => 0.75,
                'EUR' => 1.25,
            ],
        ],
    ],
];
```

## How do you use this package?

Example usage in a controller:

```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $router = app('payment.router');
        $paymentDetails = [
            'amount' => $request->amount,
            'card_number' => $request->card_number,
            'transaction_id' => time() . rand(1000, 9999), // NB: Modify as needed
            'currency' => $request->currency // Example: 'USD',
        ];

        try {
            $processor = $router->route($paymentDetails);
            $data = $processor->processPayment($paymentDetails);

            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

```

## How do you run phpunit test?

Run the command below:

```bash
vendor/bin/phpunit
```

## License

The Payment Router package is open-sourced software licensed under the
[MIT license](https://opensource.org/licenses/MIT)
