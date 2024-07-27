<?php

return [
    'processors' => [
        'flutterwave' => [
            'class' => Kevchikezie\PaymentRouter\Processors\FlutterwaveProcessor::class,
            'secret_key' => env('FLUTTERWAVE_SECRET_KEY'),
            'public_key' => env('FLUTTERWAVE_PUBLIC_KEY'),
            'supported_currencies' => ['USD', 'GBP', 'NGN', 'GHS'],
            'transaction_cost' => [
                'USD' => 1.75,
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
