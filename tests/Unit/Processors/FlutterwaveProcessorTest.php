<?php

namespace Kevchikezie\PaymentRouter\Tests\Unit\Processors;

use Orchestra\Testbench\TestCase;
use Kevchikezie\PaymentRouter\Processors\FlutterwaveProcessor;

class FlutterwaveProcessorTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('payment-router.processors', [
            'flutterwave' => [
                'class' => \Kevchikezie\PaymentRouter\Processors\FlutterwaveProcessor::class,
                'secret_key' => env('FLUTTERWAVE_SECRET_KEY'),
                'public_key' => env('FLUTTERWAVE_PUBLIC_KEY'),
                'supported_currencies' => ['USD', 'EUR', 'NGN'],
                'transaction_cost' => [
                    'USD' => 2.9,
                    'EUR' => 2.5,
                    'NGN' => 100
                ]
            ]
        ]);
    }

    public function testProcessPayment()
    {
        $config = config('payment-router.processors');
        $processor = new FlutterwaveProcessor($config);
        $paymentDetails = ['amount' => 1000, 'currency' => 'USD', 'card_number' => '4111111111111111'];

        $result = $processor->processPayment($paymentDetails);

        $expectedResult = [
            'amount' => 1000,
            'currency' => 'USD',
            'card_number' => '4111111111111111',
            'transaction_fee' => 2.9,
            'processor' => 'flutterwave'
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function testGetTransactionCost()
    {
        $config = config('payment-router.processors');
        $processor = new FlutterwaveProcessor($config);
        $cost = $processor->getTransactionCost('USD');

        $this->assertEquals(2.9, $cost);
    }

    public function testSupportsCurrency()
    {
        $config = config('payment-router.processors');
        $processor = new FlutterwaveProcessor($config);

        $this->assertTrue($processor->supportsCurrency('USD'));
        $this->assertFalse($processor->supportsCurrency('JPY'));
    }
}
