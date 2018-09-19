<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Product;


class EditProductTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function users_can_view_product_edit_form_when_a_valid_product_is_requested()
    {
        $product = factory(Product::class)->create();
        
        $response = $this->get("/products/{$product->product_id}/edit");

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
    public function users_cannot_access_a_product_that_does_not_exists()
    {
        $response = $this->get("products/99999/edit");

        $response->assertStatus(302);
        $response->assertRedirect('/products');
    }

    /** @test */
    public function users_can_edit_an_existing_product()
    {
        //$this->withoutExceptionHandling();

        $product = factory(Product::class)->create([
            'product_name' => 'Old Name',
            'product_description' => 'Old Description',
            'product_price' => 15.50,
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ]);

        $product_id = $product->product_id;

        $response = $this->post("products/{$product->product_id}", [
            'product_name' => 'Product Name Updated',
            'product_description' => 'This is a simple updated test description',
            'product_price' => 5.30,
            'product_width' => 15.0,
            'product_length' => 14.0,
            'product_height' => 15.0,
            'product_weight' => 10
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/products');

        tap(Product::findOrfail($product_id), function($product){
            $this->assertEquals('Product Name Updated', $product->product_name);
            $this->assertEquals('This is a simple updated test description', $product->product_description);
            $this->assertEquals(5.30, $product->product_price);
            $this->assertEquals(15.0, $product->product_width);
            $this->assertEquals(14.0, $product->product_length);
            $this->assertEquals(15.0, $product->product_height);
            $this->assertEquals(10, $product->product_weight);
        });
        
    }

    /** @test */
    public function product_name_is_required_in_order_to_update_a_product()
    {
        //$this->withoutExceptionHandling();

        $product = factory(Product::class)->create([
            'product_name' => 'Old Name',
            'product_description' => 'Old Description',
            'product_price' => 15.50,
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ]);

        $product_id = $product->product_id;
        session()->setPreviousUrl(url('/products/{$product_id}/edit'));

        $updated_product = [
            'product_description' => 'This is a simple test description',
            'product_price' => 5.30,
            'product_width' => 15.0,
            'product_length' => 14.0,
            'product_height' => 15.0,
            'product_weight' => 10
        ];

        $response = $this->post("products/{$product->product_id}", $updated_product);

        $response->assertStatus(302);
        $response->assertRedirect('/products/{$product_id}/edit');
        $response->assertSessionHasErrors('product_name');

        // since the update should fail then none of the data should have changed
        tap(Product::findOrfail($product_id), function($product){
            $this->assertEquals('Old Name', $product->product_name);
            $this->assertEquals('Old Description', $product->product_description);
            $this->assertEquals(15.50, $product->product_price);
            $this->assertEquals(4.50, $product->product_width);
            $this->assertEquals(5.40, $product->product_length);
            $this->assertEquals(6.50, $product->product_height);
            $this->assertEquals(6.0, $product->product_weight);
        });
    }


    /** @test */
    public function product_price_is_required_in_order_to_update_a_product()
    {
        //$this->withoutExceptionHandling();

        $product = factory(Product::class)->create([
            'product_name' => 'Old Name',
            'product_description' => 'Old Description',
            'product_price' => 15.50,
            'product_width' => 4.50,
            'product_length' => 5.40,
            'product_height' => 6.50,
            'product_weight' => 6.0
        ]);

        $product_id = $product->product_id;
        session()->setPreviousUrl(url('/products/{$product_id}/edit'));

        $updated_product = [
            'product_name' => 'Product Name Updated',
            'product_description' => 'This is a simple test description',
            'product_width' => 15.0,
            'product_length' => 14.0,
            'product_height' => 15.0,
            'product_weight' => 10
        ];

        $response = $this->post("products/{$product->product_id}", $updated_product);

        $response->assertStatus(302);
        $response->assertRedirect('/products/{$product_id}/edit');
        $response->assertSessionHasErrors('product_price');

        // since the update should fail then none of the data should have changed
        tap(Product::findOrfail($product_id), function($product){
            $this->assertEquals('Old Name', $product->product_name);
            $this->assertEquals('Old Description', $product->product_description);
            $this->assertEquals(15.50, $product->product_price);
            $this->assertEquals(4.50, $product->product_width);
            $this->assertEquals(5.40, $product->product_length);
            $this->assertEquals(6.50, $product->product_height);
            $this->assertEquals(6.0, $product->product_weight);
        });
    }


}