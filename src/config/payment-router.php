<?php

return [
    'processors' => [
        'flutterwave' => [
            'class' => Kevchikezie\PaymentRouter\Processors\FlutterwaveProcessor::class,
            'secret_key' => env('FLUTTERWAVE_SECRET_KEY'),
            'public_key' => env('FLUTTERWAVE_PUBLIC_KEY'),
        ],
        'paystack' => [
            'class' => Kevchikezie\PaymentRouter\Processors\PaystackProcessor::class,
            'secret_key' => env('PAYSTACK_SECRET_KEY'),
            'public_key' => env('PAYSTACK_PUBLIC_KEY'),
        ],
    ],
];
