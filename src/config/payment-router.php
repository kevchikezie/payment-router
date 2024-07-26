<?php

return [
    'processors' => [
        'flutterwave' => [
            'class' => Kevchikezie\PaymentRouter\Processors\FlutterwaveProcessor::class,
            'api_key' => env('STRIPE_API_KEY'),
        ],
        'paystack' => [
            'class' => Kevchikezie\PaymentRouter\Processors\PaystackProcessor::class,
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYPAL_CLIENT_SECRET'),
        ],
    ],
];
