<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Product;


class DeleteProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function user_can_delete_an_existing_product()
    {
        //$this->withoutExceptionHandling();

        $this->assertEquals(0, Product::count());
        $product = factory(Product::class)->create();
        $product_id = $product->product_id;
        $this->assertEquals(1, Product::count());

        $response = $this->get("/products/{$product_id}/remove");

        $response->assertStatus(200);
        $response->assertExactJson([
            'deleted' => true
        ]);
        $this->assertEquals(0, Product::count());

    }

    /** @test */
    public function user_cannot_delete_non_existing_product()
    {
        $this->assertEquals(0, Product::count());

        $response = $this->get("/products/999999/remove");

        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => 'Product Does Not Exists'
        ]);
        $this->assertEquals(0, Product::count());

    }
}