<?php

namespace Kevchikezie\PaymentRouter\Processors;

class FlutterwaveProcessor extends PaymentProcessorAdapter
{
    public function processPayment(array $paymentDetails)
    {
        // Process payment using Flutterwave
    }

    public function getTransactionCost(): float
    {
        return 0.75;
    }

    public function getReliabilityScore(): float
    {
        return 70;
    }

    public function supportsCurrency(string $currency): bool
    {
        $supportedCurrencies = ['NGN', 'USD', 'GBP'];
        return in_array($currency, $supportedCurrencies);
    }
}
