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

    abstract public function getProcessorName(): string;
    abstract public function processPayment(array $paymentDetails);
    abstract public function getTransactionCost(string $currency): float;
    abstract public function supportsCurrency(string $currency): bool;
}
