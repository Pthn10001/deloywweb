<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_name' => $this->faker->word(),
            'product_desc' => $this->faker->sentence(),
            'product_price' => $this->faker->numberBetween(10000, 1000000),
            'category_id' => 1, // Default, can be overridden
            'brand_id' => 1, // Default, can be overridden
            'product_image' => $this->faker->imageUrl(200, 200, 'fashion'),
            'product_content' => $this->faker->paragraph(),
            'product_status' => 0,
            'product_quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
