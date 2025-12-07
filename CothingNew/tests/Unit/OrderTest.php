<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Order;

class OrderTest extends TestCase
{
    /** @test */
    public function it_can_create_an_order()
    {
        $order = new Order([
            'customer_id' => 1,
            'order_total' => 100000,
            'order_status' => 0,
        ]);
        $this->assertEquals(1, $order->customer_id);
        $this->assertEquals(100000, $order->order_total);
        $this->assertEquals(0, $order->order_status);
    }

    /** @test */
    public function it_has_default_status()
    {
        $order = new Order();
        $this->assertTrue(isset($order->order_status));
    }
}
