<?php

namespace Kevchikezie\PaymentRouter\Processors;

class FlutterwaveProcessor extends PaymentProcessorAdapter
{
    private $supportedCurrencies = ['USD', 'GBP', 'NGN', 'GHS'];
    private $processor = 'flutterwave';

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
            'USD' => 1.75,
            'GBP' => 1.9,
            'NGN' => 0.25,
            'GHS' => 0.23
        ];

        return $transactionCost[$currency];
    }

    public function getReliabilityScore(): float
    {
        return 70;
    }

    public function supportsCurrency(string $currency): bool
    {
        return in_array($currency, $this->supportedCurrencies);
    }
}
