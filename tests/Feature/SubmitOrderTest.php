<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Order;
use App\OrderItem;
use App\Product;


class SubmitOrderTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function user_is_redirected_to_checkout_when_missing_first_name_on_submition()
    {
        //$this->withoutExceptionHandling();

        session()->setPreviousUrl(url('/orders/checkout'));

        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        $this->post("/orders/", ['product_id' => $product->product_id]);

        $order = Order::where('order_id', 1)->firstOrFail();
        
        // get items associated to the order
        $orderItem = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($product->product_price, $order->order_total);

        $data = [
            'order_address' => '273 Hecker St',
            'order_customer_last_name' => 'Bonilla',
            'order_city' => 'Staten Island',
            'order_state' => 'New York',
            'order_zip' => '10307'
        ];

        $response = $this->post("/orders/checkout", $data);
        $response->assertStatus(302);
        $response->assertRedirect('/orders/checkout');
        $response->assertSessionHasErrors('order_customer_first_name');
        $this->assertEquals(1, $order->order_status);
        
    }

    /** @test */
    public function user_is_redirected_to_checkout_when_missing_last_name_on_submition()
    {
        //$this->withoutExceptionHandling();

        session()->setPreviousUrl(url('/orders/checkout'));

        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        $this->post("/orders/", ['product_id' => $product->product_id]);

        $order = Order::where('order_id', 1)->firstOrFail();
        
        // get items associated to the order
        $orderItem = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($product->product_price, $order->order_total);

        $data = [
            'order_address' => '273 Hecker St',
            'order_customer_first_name' => 'Sebastian',
            'order_city' => 'Staten Island',
            'order_state' => 'New York',
            'order_zip' => '10307'
        ];

        $response = $this->post("/orders/checkout", $data);
        $response->assertStatus(302);
        $response->assertRedirect('/orders/checkout');
        $response->assertSessionHasErrors('order_customer_last_name');
        $this->assertEquals(1, $order->order_status);
        
    }

    /** @test */
    public function user_is_redirected_to_checkout_when_missing_address_on_submition()
    {
        //$this->withoutExceptionHandling();

        session()->setPreviousUrl(url('/orders/checkout'));

        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        $this->post("/orders/", ['product_id' => $product->product_id]);

        $order = Order::where('order_id', 1)->firstOrFail();
        
        // get items associated to the order
        $orderItem = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($product->product_price, $order->order_total);

        $data = [
            'order_customer_first_name' => 'Sebastian',
            'order_customer_last_name' => 'Bonilla',
            'order_city' => 'Staten Island',
            'order_state' => 'New York',
            'order_zip' => '10307'
        ];

        $response = $this->post("/orders/checkout", $data);
        $response->assertStatus(302);
        $response->assertRedirect('/orders/checkout');
        $response->assertSessionHasErrors('order_address');
        $this->assertEquals(1, $order->order_status);
        
    }

    /** @test */
    public function user_is_redirected_to_checkout_when_missing_city_on_submition()
    {
        //$this->withoutExceptionHandling();

        session()->setPreviousUrl(url('/orders/checkout'));

        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        $this->post("/orders/", ['product_id' => $product->product_id]);

        $order = Order::where('order_id', 1)->firstOrFail();
        
        // get items associated to the order
        $orderItem = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($product->product_price, $order->order_total);

        $data = [
            'order_address' => '273 Hecker St',
            'order_customer_first_name' => 'Sebastian',
            'order_customer_last_name' => 'Bonilla',
            'order_state' => 'New York',
            'order_zip' => '10307'
        ];

        $response = $this->post("/orders/checkout", $data);
        $response->assertStatus(302);
        $response->assertRedirect('/orders/checkout');
        $response->assertSessionHasErrors('order_city');
        $this->assertEquals(1, $order->order_status);
        
    }

    /** @test */
    public function user_is_redirected_to_checkout_when_missing_state_on_submition()
    {
        //$this->withoutExceptionHandling();

        session()->setPreviousUrl(url('/orders/checkout'));

        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        $this->post("/orders/", ['product_id' => $product->product_id]);

        $order = Order::where('order_id', 1)->firstOrFail();
        
        // get items associated to the order
        $orderItem = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($product->product_price, $order->order_total);

        $data = [
            'order_address' => '273 Hecker St',
            'order_customer_first_name' => 'Sebastian',
            'order_customer_last_name' => 'Bonilla',
            'order_city' => 'Staten Island',
            'order_zip' => '10307'
        ];

        $response = $this->post("/orders/checkout", $data);
        $response->assertStatus(302);
        $response->assertRedirect('/orders/checkout');
        $response->assertSessionHasErrors('order_state');
        $this->assertEquals(1, $order->order_status);
        
    }

    /** @test */
    public function user_is_redirected_to_checkout_when_missing_zip_on_submition()
    {
        //$this->withoutExceptionHandling();

        session()->setPreviousUrl(url('/orders/checkout'));

        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        $this->post("/orders/", ['product_id' => $product->product_id]);

        $order = Order::where('order_id', 1)->firstOrFail();
        
        // get items associated to the order
        $orderItem = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($product->product_price, $order->order_total);

        $data = [
            'order_address' => '273 Hecker St',
            'order_customer_first_name' => 'Sebastian',
            'order_customer_last_name' => 'Bonilla',
            'order_city' => 'Staten Island',
            'order_state' => 'New York',
        ];

        $response = $this->post("/orders/checkout", $data);
        $response->assertStatus(302);
        $response->assertRedirect('/orders/checkout');
        $response->assertSessionHasErrors('order_zip');
        $this->assertEquals(1, $order->order_status);
        
    }

    /** @test */
    public function order_is_marked_as_submitted_when_checkout_is_successfull()
    {
        //$this->withoutExceptionHandling();
        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        $this->post("/orders/", ['product_id' => $product->product_id]);

        $order = Order::where('order_id', 1)->firstOrFail();
        
        // get items associated to the order
        $orderItem = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($product->product_price, $order->order_total);

        $data = [
            'order_customer_first_name' => 'Sebastian',
            'order_customer_last_name' => 'Bonilla',
            'order_address' => '273 Hecker St',
            'order_city' => 'Staten Island',
            'order_state' => 'New York',
            'order_zip' => '10307',
        ];

        $response = $this->post("/orders/checkout", $data);
        $response->assertStatus(302);
        $response->assertRedirect('/products/');

        $updatedOrder = Order::where('order_id', 1)->firstOrFail();
        
        $this->assertEquals($data['order_address'], $updatedOrder->order_address);
        $this->assertEquals($data['order_customer_first_name'], $updatedOrder->order_customer_first_name);
        $this->assertEquals($data['order_customer_last_name'], $updatedOrder->order_customer_last_name);
        $this->assertEquals($data['order_city'], $updatedOrder->order_city);
        $this->assertEquals($data['order_state'], $updatedOrder->order_state);
        $this->assertEquals($data['order_zip'], $updatedOrder->order_zip);
        $this->assertEquals(2, $updatedOrder->order_status);
    }

}
