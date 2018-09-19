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

        if (is_null($order)) return view('orders.noorders');

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

    public function completeCheckout(Request $request) : Object
    {
        // validate data
        $request->validate([  
            'order_customer_first_name' => 'required',
            'order_customer_last_name' => 'required',
            'order_address' => 'required',
            'order_city' => 'required',
            'order_state' => 'required',
            'order_zip' => 'required'
        ]);

        $order = Order::where(['order_status' => 1])->first();
        if (is_null($order)) return view('orders.noorders');

        $order->update([
            'order_status' => 2,
            'order_customer_first_name' => $request->order_customer_first_name,
            'order_customer_last_name' => $request->order_customer_last_name,
            'order_address' => $request->order_address,
            'order_city' => $request->order_city,
            'order_state' => $request->order_state,
            'order_zip' => $request->order_zip
        ]);
        
        return redirect('products')->with('success', 'Your order is now being processed by our great customer associates');
    }

}
