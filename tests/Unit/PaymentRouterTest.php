<?php

namespace Kevchikezie\PaymentRouter\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Kevchikezie\PaymentRouter\PaymentRouter;
use Kevchikezie\PaymentRouter\Contracts\PaymentProcessorInterface;
use Mockery;
use Illuminate\Support\Facades\Log;

class PaymentRouterTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testRouteSelectsProcessorBasedOnCost()
    {
        $router = new PaymentRouter();

        $processor1 = Mockery::mock(PaymentProcessorInterface::class);
        $processor1->shouldReceive('supportsCurrency')->andReturn(true);
        $processor1->shouldReceive('getTransactionCost')->andReturn(2.5);

        $processor2 = Mockery::mock(PaymentProcessorInterface::class);
        $processor2->shouldReceive('supportsCurrency')->andReturn(true);
        $processor2->shouldReceive('getTransactionCost')->andReturn(1.5);

        $router->addProcessor('processor1', $processor1);
        $router->addProcessor('processor2', $processor2);

        $paymentDetails = ['currency' => 'USD'];
        $selectedProcessor = $router->route($paymentDetails);

        $this->assertSame($processor2, $selectedProcessor);
    }

    public function testRouteThrowsExceptionWhenNoProcessorSupportsCurrency()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Payment processing failed.');

        Log::shouldReceive('error')->once();

        $router = new PaymentRouter();

        $processor1 = Mockery::mock(PaymentProcessorInterface::class);
        $processor1->shouldReceive('supportsCurrency')->andReturn(false);
        $processor1->shouldReceive('getTransactionCost')->andReturn(1.5);

        $processor2 = Mockery::mock(PaymentProcessorInterface::class);
        $processor2->shouldReceive('supportsCurrency')->andReturn(false);
        $processor2->shouldReceive('getTransactionCost')->andReturn(1.5);

        $router->addProcessor('processor1', $processor1);
        $router->addProcessor('processor2', $processor2);

        $paymentDetails = ['currency' => 'USD'];
        $router->route($paymentDetails);
    }
}
