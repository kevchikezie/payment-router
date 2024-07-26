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
        $paymentDetails['card_number'] = Crypt::encrypt($paymentDetails['card_number']);

        $selectedProcessor = null;
        $lowestCost = PHP_FLOAT_MAX;

        foreach ($this->processors as $processor) {
            if ($processor->supportsCurrency($paymentDetails['currency'])) {
                $cost = $processor->getTransactionCost();
                if ($cost < $lowestCost) {
                    $lowestCost = $cost;
                    $selectedProcessor = $processor;
                }
            }
        }

        if ($selectedProcessor === null) {
            Log::error("No suitable payment processor found.");
            throw new \Exception("No suitable payment processor found.");
        }

        Log::info("Payment routed to processor", ['processor' => get_class($selectedProcessor)]);
        return $selectedProcessor;
    }
}
