<?php

namespace Kevchikezie\PaymentRouter\Contracts;

interface PaymentProcessorInterface
{
    public function getProcessorName(): string;
    public function processPayment(array $paymentDetails);
    public function getTransactionCost(string $currency): float;
    public function supportsCurrency(string $currency): bool;
}
