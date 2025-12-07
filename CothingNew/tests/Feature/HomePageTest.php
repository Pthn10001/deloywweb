<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class HomePageTest extends TestCase
    use \Illuminate\Foundation\Testing\RefreshDatabase;
{
    /**
     * Test 1: Homepage hiển thị thành công (HTTP 200)
     */
    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs('pages.home');
    }

    /**
     * Test 2: Homepage hiển thị danh sách sản phẩm
     */
    public function test_homepage_displays_products()
    {
        // Tạo sản phẩm test
        $product = Product::factory()->create([
            'product_name' => 'Test Shirt',
            'product_price' => 50000,
            'product_quantity' => 10
        ]);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSeeText('Test Shirt');
        $response->assertSeeText('50000');
    }

    /**
     * Test 3: Homepage hiển thị đúng số lượng sản phẩm
     */
    public function test_homepage_displays_correct_product_count()
    {
        // Tạo 5 sản phẩm
        Product::factory()->count(5)->create();

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $this->assertCount(5, $response->viewData('product_all'));
    }

    /**
     * Test 4: Homepage hiển thị sản phẩm theo danh mục
     */
    public function test_homepage_products_have_categories()
    {
        $category = Category::factory()->create([
            'category_name' => 'T-Shirt',
            'category_status' => 0
        ]);

        $product = Product::factory()->create([
            'category_id' => $category->category_id
        ]);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $products = $response->viewData('product_all');
        
        $this->assertTrue($products->contains('product_id', $product->product_id));
    }

    /**
     * Test 5: Homepage chỉ hiển thị sản phẩm active
     */
    public function test_homepage_displays_only_active_products()
    {
        // Tạo sản phẩm active
        $active = Product::factory()->create([
            'product_name' => 'Active Product',
            'product_status' => 0
        ]);

        // Tạo sản phẩm inactive
        $inactive = Product::factory()->create([
            'product_name' => 'Inactive Product',
            'product_status' => 1
        ]);

        $response = $this->get('/');
        
        $response->assertSeeText('Active Product');
        $response->assertDontSeeText('Inactive Product');
    }

    /**
     * Test 6: Trang không trả về error
     */
    public function test_homepage_no_console_errors()
    {
        $response = $this->get('/');
        
        // Kiểm tra không có exception
        $response->assertStatus(200);
    }

    /**
     * Test 7: SEO meta tags có mặt
     */
    public function test_homepage_has_meta_tags()
    {
        $response = $this->get('/');
        
        // Kiểm tra meta description, keywords, title
        $this->assertNotNull($response->viewData('meta_desc'));
        $this->assertNotNull($response->viewData('meta_keywords'));
        $this->assertNotNull($response->viewData('meta_title'));
    }

    /**
     * Test 8: HTML structure đúng (có owl-carousel)
     */
    public function test_homepage_has_carousel_structure()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        // Kiểm tra có product_active owl-carousel class
        $content = $response->getContent();
        $this->assertStringContainsString('product_active', $content);
    }
}
