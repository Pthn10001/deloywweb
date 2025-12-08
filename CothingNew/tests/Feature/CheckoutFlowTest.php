<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Customer;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;
    protected $products = [];

    public function setUp(): void
    {
        parent::setUp();
        
        $this->customer = Customer::factory()->create([
            'customer_email' => 'test@example.com',
            'customer_name' => 'Test User',
            'customer_phone' => '0912345678'
        ]);

        $this->products = Product::factory()->count(3)->create([
            'product_status' => 0,
            'product_quantity' => 50
        ]);
    }

    public function test_email_validation_required()
    {
        $this->actingAs($this->customer);

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => '',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('shipping_email');
    }

    public function test_email_validation_format()
    {
        $this->actingAs($this->customer);

        $response = $this->postJson('/order', [
            'shipping_email' => 'invalid-email',
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('shipping_email');
    }

    public function test_phone_validation_length()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => 50000,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        // Test: Phone < 10 số
        $response = $this->postJson('/order', [
            'shipping_phone' => '0912',
            'shipping_name' => 'Test User',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);
    }

    public function test_phone_validation_10_digits()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => 50000,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_phone' => '0912345678',
            'shipping_name' => 'Test User',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_phone_validation_11_digits()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => 50000,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_phone' => '09123456789',
            'shipping_name' => 'Test User',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_required_fields_validation()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => 50000,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_name' => '',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('shipping_name');
    }

    public function test_payment_method_validation()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => 50000,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 99
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('payment_method');
    }

    public function test_create_order_successfully()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => 50000,
                'product_qty' => 2,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'shipping_notes' => 'Giao lúc 10-15h',
            'payment_method' => 1
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tbl_order', [
            'customer_id' => $this->customer->customer_id,
            'order_status' => 1
        ]);
    }

    public function test_order_details_saved_correctly()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => 'Product 1',
                'product_price' => 50000,
                'product_qty' => 2,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(200);
        $orderCode = $response->json('order_code');

        $this->assertDatabaseHas('tbl_order_details', [
            'order_code' => $orderCode,
            'product_id' => $this->products[0]->product_id,
            'product_sales_qty' => 2,
            'product_size' => 'M'
        ]);
    }

    public function test_cart_cleared_after_order()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => 50000,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(200);
        $this->assertNull(session()->get('cart'));
    }

    public function test_null_customer_returns_error()
    {
        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => 50000,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(401);
    }

    public function test_empty_cart_returns_error()
    {
        $this->actingAs($this->customer);

        session()->put('cart', []);
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);
    }
}
