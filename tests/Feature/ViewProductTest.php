<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Product;


class ViewProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function user_can_view_an_existing_product()
    {
        //$this->withoutExceptionHandling();

        $product = factory(Product::class)->create();

        $response = $this->get("products/{$product->product_id}");

        $response->assertStatus(200);

        // make sure user can see product details
        $response->assertSee($product->product_id);
        $response->assertSee($product->product_name);
        $response->assertSee($product->product_description);
        $response->assertSee($product->product_width);
        $response->assertSee($product->product_length);
        $response->assertSee($product->product_height);
        $response->assertSee($product->product_weight);
        $response->assertSee($product->product_price);
    }


    /** @test */
    public function when_user_try_to_view_non_existing_item_then_it_is_redirected_to_products_page()
    {
        $response = $this->get("products/9999999");

        $response->assertStatus(302);
        $response->assertRedirect('/products');
    }


    /** @test */
    public function user_can_view_list_of_products()
    {
        $this->withoutExceptionHandling();

        $products = factory(Product::class, 10)->create();
        
        $response = $this->get("products/");

        $response->assertStatus(200);

        foreach ($products as $product) {
            $response->assertSee($product->product_id);
            $response->assertSee($product->product_name);
            $response->assertSee($product->product_description);
            $response->assertSee($product->product_width);
            $response->assertSee($product->product_length);
            $response->assertSee($product->product_height);
            $response->assertSee($product->product_weight);
            $response->assertSee($product->product_price);
        }
    }
}