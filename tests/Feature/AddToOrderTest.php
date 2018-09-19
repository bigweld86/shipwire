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


class AddToOrderTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function when_user_adds_one_product_to_non_existing_order_then_new_order_is_created()
    {
        //$this->withoutExceptionHandling();

        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        $response = $this->post("/orders/", ['product_id' => $product->product_id]);

        $this->assertEquals(1, Order::count());
    }


    /** @test */
    public function user_can_add_one_item_to_order()
    {
        //$this->withoutExceptionHandling();

        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        $response = $this->post("/orders/", ['product_id' => $product->product_id]);

        $order = Order::where('order_id', 1)->firstOrFail();
        
        // get items associated to the order
        $orderItem = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($product->product_price, $order->order_total);

        foreach($orderItem as $item) {
            $this->assertEquals($product->product_id, $item->orderitem_product_id);
            $this->assertEquals($order->order_id, $item->orderitem_order_id);
            $this->assertEquals($product->product_price, $item->orderitem_price);
            $this->assertEquals(1, $item->orderitem_qty);
        }    
    }


    /** @test */
    public function user_can_add_multiple_items_to_the_same_order()
    {
        //$this->withoutExceptionHandling();

        $products = factory(Product::class, 3)->create();
        
        $this->assertEquals(0, Order::count());

        foreach ($products as $product) {
            $this->post("/orders/", ['product_id' => $product->product_id]);
        }

        $order = Order::where('order_id', 1)->firstOrFail();
        
        // get items associated to the order
        $orderItems = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(3, OrderItem::count());
        $this->assertEquals($products->sum('product_price'), $order->order_total);

        foreach($orderItems as $item) {
            $product = Product::findOrFail($item->orderitem_product_id);
            $this->assertEquals($product->product_id, $item->orderitem_product_id);
            $this->assertEquals($order->order_id, $item->orderitem_order_id);
            $this->assertEquals($product->product_price, $item->orderitem_price);
            $this->assertEquals(1, $item->orderitem_qty);
        }
    }

    /** @test */
    public function when_item_is_added_more_than_once_then_qty_is_updated()
    {
        //$this->withoutExceptionHandling();

        $product = factory(Product::class)->create();
        
        $this->assertEquals(0, Order::count());

        // add item twice
        $this->post("/orders/", ['product_id' => $product->product_id]);
        $this->post("/orders/", ['product_id' => $product->product_id]);
        
        $order = Order::where('order_id', 1)->firstOrFail();
        
        $orderItems = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($product->product_price * 2, $order->order_total);

        foreach($orderItems as $item) {
            $product = Product::findOrFail($item->orderitem_product_id);
            $this->assertEquals($product->product_id, $item->orderitem_product_id);
            $this->assertEquals($order->order_id, $item->orderitem_order_id);
            $this->assertEquals($product->product_price, $item->orderitem_price);
            $this->assertEquals(2, $item->orderitem_qty);
        }
    }

    /** @test */
    public function when_item_is_added_more_than_once_then_order_total_is_updated()
    {

        //$this->withoutExceptionHandling();

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
        
        $order = Order::where('order_id', 1)->firstOrFail();
        
        $orderItems = $order->orderItems;

        $this->assertEquals(1, Order::count());
        $this->assertEquals(6, OrderItem::count());
        $grandTotal = $products->sum('product_price') + ($repeatedProduct->product_price * 2);
        $this->assertEquals($grandTotal, $order->order_total);

        foreach($orderItems as $item) {
            $product = Product::findOrFail($item->orderitem_product_id);
            $this->assertEquals($product->product_id, $item->orderitem_product_id);
            $this->assertEquals($order->order_id, $item->orderitem_order_id);
            $this->assertEquals($product->product_price, $item->orderitem_price);

            if ($product->product_id === $repeatedProductId) {
                $this->assertEquals(2, $item->orderitem_qty);    
            } else {
                $this->assertEquals(1, $item->orderitem_qty);
            }
        }

    }

    /** @test */
    public function user_cannot_add_non_existing_item_to_order()
    {
        // implement
    }

}