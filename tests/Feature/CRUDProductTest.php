<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Product;


class CRUDProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function non_authenticated_user_can_add_a_product()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_price' => 1500,
            'product_width' => 450,
            'product_length' => 540,
            'product_height' => 650,
            'product_weight' => 60
        ];

        // 2. Act
        $response = $this->post("/products/", $data);
        
        $response->assertRedirect('/products');
        $this->assertEquals(1, Product::count());

        $product = Product::first();

        $this->assertEquals($data['product_name'], $product->product_name);
        $this->assertEquals($data['product_description'], $product->product_description);
        $this->assertEquals($data['product_price'], $product->product_price);
        $this->assertEquals($data['product_width'], $product->product_width);
        $this->assertEquals($data['product_length'], $product->product_length);
        $this->assertEquals($data['product_height'], $product->product_height);
        $this->assertEquals($data['product_weight'], $product->product_weight);
    }

}
