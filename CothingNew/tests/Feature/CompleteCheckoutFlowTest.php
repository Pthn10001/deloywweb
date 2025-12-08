<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;

class CompleteCheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;
    protected $products = [];

    public function setUp(): void
    {
        parent::setUp();
        
        // Chuẩn bị dữ liệu test
        $this->customer = Customer::factory()->create([
            'customer_email' => 'test@example.com',
            'customer_name' => 'Test User',
            'customer_phone' => '0912345678'
        ]);

        // Tạo 3 sản phẩm
        $this->products = Product::factory()->count(3)->create([
            'product_status' => 0,
            'product_quantity' => 50
        ]);
    }

    /**
     * Test 1: Create cart with products
     */
    public function test_1_create_cart_with_products()
    {
        $cart = [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => $this->products[0]->product_price,
                'product_qty' => 2,
                'product_size' => 'M'
            ],
            [
                'product_id' => $this->products[1]->product_id,
                'product_name' => $this->products[1]->product_name,
                'product_price' => $this->products[1]->product_price,
                'product_qty' => 1,
                'product_size' => 'L'
            ]
        ];

        session()->put('cart', $cart);
        session()->put('customer_id', $this->customer->customer_id);

        $this->assertNotNull(session()->get('cart'));
        $this->assertEquals(2, count(session()->get('cart')));
    }

    /**
     * ✅ TEST 2: Kiểm tra Validation Form Email
     */
    public function test_2_checkout_form_email_validation()
    {
        $this->actingAs($this->customer);

        // Test 1: Email trống
        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => '',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('shipping_email');

        // Test 2: Email không hợp lệ
        $response = $this->postJson('/order', [
            'shipping_email' => 'invalid-email',
            'shipping_name' => 'Test',
            'shipping_phone' => '0912345678',
            'shipping_address' => '123 Main',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);

        // Test 3: Email hợp lệ
        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => $this->products[0]->product_price,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_email' => 'test@example.com',
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(200);
        
        echo "\n✅ TEST 2 PASS: Email validation hoạt động\n";
    }

    /**
     * ✅ TEST 3: Kiểm tra Validation Phone Pattern
     */
    public function test_3_checkout_form_phone_validation()
    {
        $this->actingAs($this->customer);

        // Test 1: Phone < 10 số
        $response = $this->postJson('/order', [
            'shipping_phone' => '0912',
            'shipping_name' => 'Test',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);

        // Test 2: Phone = 10 số (hợp lệ)
        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => $this->products[0]->product_price,
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

        // Test 3: Phone = 11 số (hợp lệ)
        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => $this->products[0]->product_price,
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
        
        echo "\n✅ TEST 3 PASS: Phone validation (10-11 số)\n";
    }

    /**
     * ✅ TEST 4: Kiểm tra Required Fields
     */
    public function test_4_checkout_required_fields_validation()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => $this->products[0]->product_price,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        // Test: Bỏ trống shipping_name
        $response = $this->postJson('/order', [
            'shipping_name' => '',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('shipping_name');

        // Test: Bỏ trống shipping_address
        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('shipping_address');

        // Test: Bỏ trống payment_method
        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('payment_method');
        
        echo "\n✅ TEST 4 PASS: Required fields validation\n";
    }

    /**
     * ✅ TEST 5: Kiểm tra Payment Method Values
     */
    public function test_5_payment_method_in_array_validation()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => $this->products[0]->product_price,
                'product_qty' => 1,
                'product_size' => 'M'
            ]
        ]);
        session()->put('customer_id', $this->customer->customer_id);

        // Test: Invalid payment_method (không trong 1,2,3)
        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 99
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('payment_method');
        
        echo "\n✅ TEST 5 PASS: Payment method validation (in:1,2,3)\n";
    }

    /**
     * ✅ TEST 6: Kiểm tra Tạo Order Thành Công
     */
    public function test_6_create_order_successfully()
    {
        $this->actingAs($this->customer);

        session()->put('cart', [
            [
                'product_id' => $this->products[0]->product_id,
                'product_name' => $this->products[0]->product_name,
                'product_price' => 50000,
                'product_qty' => 2,
                'product_size' => 'M'
            ],
            [
                'product_id' => $this->products[1]->product_id,
                'product_name' => $this->products[1]->product_name,
                'product_price' => 75000,
                'product_qty' => 1,
                'product_size' => 'L'
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
        $response->assertJsonStructure(['message']);
        
        // Kiểm tra Order được tạo trong DB
        $this->assertDatabaseHas('tbl_order', [
            'customer_id' => $this->customer->customer_id,
            'order_status' => 1
        ]);

        // Kiểm tra Shipping được tạo
        $this->assertDatabaseHas('tbl_shipping', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);
        
        echo "\n✅ TEST 6 PASS: Tạo order + shipping thành công\n";
    }

    /**
     * ✅ TEST 7: Kiểm tra Order Details
     */
    public function test_7_create_order_details_correctly()
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

        // Lấy order code từ response
        $orderCode = $response->json('order_code');

        // Kiểm tra OrderDetail
        $this->assertDatabaseHas('tbl_order_details', [
            'order_code' => $orderCode,
            'product_id' => $this->products[0]->product_id,
            'product_name' => 'Product 1',
            'product_price' => 50000,
            'product_sales_qty' => 2,
            'product_size' => 'M'
        ]);
        
        echo "\n✅ TEST 7 PASS: Order details lưu đúng\n";
    }

    /**
     * ✅ TEST 8: Kiểm tra Cart Được Xóa Sau Khi Order
     */
    public function test_8_cart_cleared_after_order()
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

        // Kiểm tra cart không rỗng trước
        $this->assertNotNull(session()->get('cart'));
        $this->assertEquals(1, count(session()->get('cart')));

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(200);

        // Kiểm tra cart được xóa sau
        $this->assertNull(session()->get('cart'));
        
        echo "\n✅ TEST 8 PASS: Cart được xóa sau khi order\n";
    }

    /**
     * ✅ TEST 9: Kiểm tra Null Customer Check
     */
    public function test_9_null_customer_id_returns_error()
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
        // KHÔNG set customer_id (null)

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment(['error' => 'Bạn chưa đăng nhập']);
        
        echo "\n✅ TEST 9 PASS: Null customer error handling\n";
    }

    /**
     * ✅ TEST 10: Kiểm tra Empty Cart Check
     */
    public function test_10_empty_cart_returns_error()
    {
        $this->actingAs($this->customer);

        session()->put('cart', []);  // Giỏ trống
        session()->put('customer_id', $this->customer->customer_id);

        $response = $this->postJson('/order', [
            'shipping_name' => 'Test User',
            'shipping_phone' => '0912345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => '123 Main St',
            'payment_method' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['error' => 'Giỏ hàng rỗng']);
        
        echo "\n✅ TEST 10 PASS: Empty cart error handling\n";
    }
}
