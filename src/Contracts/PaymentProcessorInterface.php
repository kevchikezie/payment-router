<?php

namespace Kevchikezie\PaymentRouter\Contracts;

interface PaymentProcessorInterface
{
    public function processPayment(array $paymentDetails);
    public function getTransactionCost(): float;
    public function getReliabilityScore(): float;
    public function supportsCurrency(string $currency): bool;
}
