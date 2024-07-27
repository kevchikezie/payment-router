<?php

namespace Kevchikezie\PaymentRouter;

use Kevchikezie\PaymentRouter\Contracts\PaymentProcessorInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class PaymentRouter
{
    protected $processors = [];

    public function addProcessor(string $name, PaymentProcessorInterface $processor)
    {
        $this->processors[$name] = $processor;
    }

    public function route(array $paymentDetails): PaymentProcessorInterface
    {
        $currency = $paymentDetails['currency'];
        $preferredProcessor = null;
        $processorTransactionCosts = [];

        // Get preferred processor based on the lowest transaction cost
        foreach ($this->processors as $processor) {
            if ($processor->supportsCurrency($currency)) {
                $transactionCost = $processor->getTransactionCost($currency);

                array_push($processorTransactionCosts, $transactionCost);
                $lowestCost = min($processorTransactionCosts);
                if ($transactionCost === $lowestCost) {
                    $preferredTransactionCost = $lowestCost;
                    $preferredProcessor = $processor;
                }
            }
        }

        if ($preferredProcessor === null) {
            throw new \Exception("No suitable payment processor found.");
        }

        return $preferredProcessor;
    }
}
