<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Product;


class AddProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function user_can_view_the_add_product_form()
    {
        $response = $this->get("/products/create");
        $response->assertStatus(200);
    }

    /** @test */
    public function adding_a_valid_product()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_price' => 15.50,
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
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


    /** @test */
    public function product_name_is_required_to_create_a_product()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        //session()->setPreviousUrl('/products/create');
        session()->setPreviousUrl(url('/products/create'));

        // create product
        $data = [
            'product_name' => '',
            'product_description' => 'This is a simple test description',
            'product_price' => 15.50,
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/products/create');
        $response->assertSessionHasErrors('product_name');
        $this->assertEquals(0, Product::count());
    }



    /** @test */
    public function product_description_is_optional_when_creating_a_new_product()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => '',
            'product_price' => 15.50,
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
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


    /** @test */
    public function product_price_is_required_when_creating_a_new_product()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        session()->setPreviousUrl(url('/products/create'));

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/products/create');
        $response->assertSessionHasErrors('product_price');
        $this->assertEquals(0, Product::count());
    }



    /** @test */
    public function product_price_has_to_be_numeric()
    {
        $this->withoutExceptionHandling();

        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        session()->setPreviousUrl(url('/products/create'));

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_price' => 'Price',
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/products/create');
        $response->assertSessionHasErrors('product_price');
        $this->assertEquals(0, Product::count());
    }



    /** @test */
    public function product_price_has_to_be_greater_than_zero()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        session()->setPreviousUrl(url('/products/create'));

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_price' => -15.50,
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/products/create');
        $response->assertSessionHasErrors('product_price');
        $this->assertEquals(0, Product::count());


        $data2 = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_price' => 0,
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data2);

        $response->assertStatus(302);
        $response->assertRedirect('/products/create');
        $response->assertSessionHasErrors('product_price');
        $this->assertEquals(0, Product::count());
    }


    /** @test */
    public function product_width_is_optional_when_creating_a_new_product()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_price' => 15.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertEquals(1, Product::count());

        $product = Product::first();

        $this->assertEquals($data['product_name'], $product->product_name);
        $this->assertEquals($data['product_description'], $product->product_description);
        $this->assertEquals($data['product_price'], $product->product_price);
        $this->assertEquals($data['product_length'], $product->product_length);
        $this->assertEquals($data['product_height'], $product->product_height);
        $this->assertEquals($data['product_weight'], $product->product_weight);
    }


    /** @test */
    public function product_length_is_optional_when_creating_a_new_product()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_price' => 15.50,
            'product_width' => 4.50,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertEquals(1, Product::count());

        $product = Product::first();

        $this->assertEquals($data['product_name'], $product->product_name);
        $this->assertEquals($data['product_description'], $product->product_description);
        $this->assertEquals($data['product_price'], $product->product_price);
        $this->assertEquals($data['product_width'], $product->product_width);
        $this->assertEquals($data['product_height'], $product->product_height);
        $this->assertEquals($data['product_weight'], $product->product_weight);
    }


    /** @test */
    public function product_height_is_optional_when_creating_a_new_product()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_price' => 15.50,
            'product_width' => 4.50,
            'product_length' => 6.50,
            'product_weight' => 6.0
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertEquals(1, Product::count());

        $product = Product::first();

        $this->assertEquals($data['product_name'], $product->product_name);
        $this->assertEquals($data['product_description'], $product->product_description);
        $this->assertEquals($data['product_price'], $product->product_price);
        $this->assertEquals($data['product_width'], $product->product_width);
        $this->assertEquals($data['product_length'], $product->product_length);
        $this->assertEquals($data['product_weight'], $product->product_weight);
    }


    /** @test */
    public function product_weight_is_optional_when_creating_a_new_product()
    {
        // 1. Arrange
        // make sure table is empty
        $this->assertEquals(0, Product::count());

        // create product
        $data = [
            'product_name' => 'Product Test',
            'product_description' => 'This is a simple test description',
            'product_price' => 15.50,
            'product_height' => 6.50,
            'product_width' => 4.50,
            'product_length' => 6.50,
        ];

        // 2. Act
        $response = $this->post("/products/", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertEquals(1, Product::count());

        $product = Product::first();

        $this->assertEquals($data['product_name'], $product->product_name);
        $this->assertEquals($data['product_description'], $product->product_description);
        $this->assertEquals($data['product_price'], $product->product_price);
        $this->assertEquals($data['product_width'], $product->product_width);
        $this->assertEquals($data['product_length'], $product->product_length);
    }

}
