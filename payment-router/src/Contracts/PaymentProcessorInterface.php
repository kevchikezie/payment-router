<?php

namespace KevChikezie\PaymentRouter\Contracts;

interface PaymentProcessorInterface
{
    public function processPayment(array $paymentDetails): bool;
    public function getTransactionCost(): float;
    public function getReliabilityScore(): float;
    public function supportsCurrency(string $currency): bool;
}
