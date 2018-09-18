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


class ViewOrderTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function user_can_view_order_items()
    {
        $this->withoutExceptionHandling();

        // create an order and add items to it
        $products = factory(Product::class, 5)->create(); 
        $repeatedProduct = factory(Product::class)->create();
        $repeatedProductId = $repeatedProduct->product_id;
        
        $this->assertEquals(0, Order::count());
        $this->post("/orders/", ['product_id' => $repeatedProductId]);

        foreach($products as $product) {
            $this->post("/orders/", ['product_id' => $product->product_id]);
        }

        // add same item a second time
        $this->post("/orders/", ['product_id' => $repeatedProductId]);
        
        // visit orders page
        $response = $this->get("/orders/");

        $response->assertStatus(200);
        $order = Order::where('order_id', 1)->firstOrFail();
        $orderItems = $order->orderItems;

        foreach($orderItems as $item) {
            $product = Product::findOrFail($item->orderitem_product_id);
            $response->assertSee($item->orderitem_product_id);
            $response->assertSee($item->orderitem_order_id);
            $response->assertSee($item->orderitem_price);
            $response->assertSee($item->orderitem_qty);
            $response->assertSee($product->product_name);

            if ($product->product_id === $repeatedProductId) {
                $this->assertEquals(2, $item->orderitem_qty);    
            } else {
                $this->assertEquals(1, $item->orderitem_qty);
            }
        }

        $response->assertSee($order->order_total);
    }

}