<?php

namespace KevChikezie\PaymentRouter\Processors;

class PaystackProcessor extends PaymentProcessorAdapter
{
    public function processPayment(array $paymentDetails)
    {
        // Process payment using Paystack
    }

    public function getTransactionCost(): float
    {
        return 1.25;
    }

    public function getReliabilityScore(): float
    {
        return 90;
    }

    public function supportsCurrency(string $currency): bool
    {
        $supportedCurrencies = ['NGN', 'USD', 'EUR'];
        return in_array($currency, $supportedCurrencies);
    }
}
