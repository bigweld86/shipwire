<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\Product;

class OrdersController extends Controller
{
    public function index() : Object
    {
        $order = Order::where(['order_status' => 1])->first();
        $data = $order->getAssociatedDataArray();   
        return view('orders.index', ['order' => $order, 'orderDetails' => $data]);
    }


    public function store(Request $request) : Object
    {
        $productId = $request->product_id;

        // validate that product exists
        if (is_null(Product::find($productId))) return redirect('products')->with('error', 'Product Does Not Exists');

        // check if an 'in progress' order already exists
        $order = Order::firstOrCreate(['order_status' => 1]);

        // create new order item
        if (is_null(OrderItem::where(['orderitem_order_id' => $order->order_id, 'orderitem_product_id' => $productId])->first())) {
            $order->createOrderItem($productId);
        } else {
            // update qty for existing item in order
            $order->updateQty($productId);
        }
        return redirect('products')->with('success', 'Product has been successfully added');
    }

    public function initCheckout() : Object
    {
        return view('orders.checkout');
    }

}
