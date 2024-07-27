<?php

namespace Kevchikezie\PaymentRouter\Processors;

class PaystackProcessor extends PaymentProcessorAdapter
{
    private $supportedCurrencies = ['NGN', 'USD', 'EUR'];
    private $processor = 'paystack';

    public function processPayment(array $paymentDetails)
    {
        $paymentDetails['transaction_fee'] = $this->getTransactionCost($paymentDetails['currency']);
        $paymentDetails['processor'] = $this->processor;

        return $paymentDetails;
    }

    public function getTransactionCost(string $currency): float
    {
        if (!in_array($currency, $this->supportedCurrencies)) {
            return null;
        }

        $transactionCost = [
            'NGN' => 0.15,
            'USD' => 0.75,
            'EUR' => 1.25,
        ];

        return $transactionCost[$currency];
    }

    public function getReliabilityScore(): float
    {
        return 90;
    }

    public function supportsCurrency(string $currency): bool
    {
        return in_array($currency, $this->supportedCurrencies);
    }
}
