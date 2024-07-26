<?php

namespace Kevchikezie\PaymentRouter\Processors;

use Kevchikezie\PaymentRouter\Contracts\PaymentProcessorInterface;

abstract class PaymentProcessorAdapter implements PaymentProcessorInterface
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    abstract public function processPayment(array $paymentDetails);
    abstract public function getTransactionCost(): float;
    abstract public function getReliabilityScore(): float;
    abstract public function supportsCurrency(string $currency): bool;
}
