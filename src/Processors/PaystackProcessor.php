<?php

namespace Kevchikezie\PaymentRouter\Processors;

class PaystackProcessor extends PaymentProcessorAdapter
{
    private $processor = 'paystack';

    public function processPayment(array $paymentDetails)
    {
        $paymentDetails['transaction_fee'] = $this->getTransactionCost($paymentDetails['currency']);
        $paymentDetails['processor'] = $this->processor;

        return $paymentDetails;
    }

    public function getTransactionCost(string $currency): float
    {
        $config = config('payment-router.processors')[$this->processor];
        $supportedCurrencies = $config['supported_currencies'];
        if (!in_array($currency, $supportedCurrencies)) {
            return null;
        }

        $transactionCost = $config['transaction_cost'];

        return $transactionCost[$currency];
    }

    public function supportsCurrency(string $currency): bool
    {
        $config = config('payment-router.processors')[$this->processor];
        $supportedCurrencies = $config['supported_currencies'];
        return in_array($currency, $supportedCurrencies);
    }
}
