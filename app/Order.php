<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\OrderItem;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_status',
        'order_total',
        'order_customer_first_name',
        'order_customer_last_name',
        'order_address',
        'order_city',
        'order_state',
        'order_zip'
    ];

    public function orderItems() : Object
    {
        return $this->hasMany(orderItem::class, 'orderitem_order_id');
    }


    public function createOrderItem(Int $productId) : void
    {
        $productPrice = Product::findOrfail($productId)->product_price;
        $item = OrderItem::create([
            'orderitem_order_id' => $this->order_id,
            'orderitem_product_id' => $productId,
            'orderitem_price' => $productPrice,
            'orderitem_qty' => 1
        ]);

        $this->updateTotal();
    }

    public function updateTotal() : void
    {
        $total = $this->orderItems->reduce(function($carry, $item){
            return $carry + ($item->orderitem_price * $item->orderitem_qty);
        });

        $this->update(['order_total' => $total]);
    }

    public function updateQty(Int $productId) : void
    {
        $this->orderItems->where('orderitem_product_id', $productId)->first()->updateQty();
        $this->updateTotal();
    }

    public function getAssociatedDataArray() : array
    {
        $result = [];
        $orderItems = OrderItem::where('orderitem_order_id', $this->order_id)->get()->toArray();
        
        foreach($orderItems as $item) {
            $data = [];
            $data['orderitem_id'] = $item['orderitem_id'];
            $data['orderitem_price'] = $item['orderitem_price'];
            $data['orderitem_qty'] = $item['orderitem_qty'];
            $data['product_details'] = Product::find($item['orderitem_product_id'])->toArray();
            
            $result[] = $data;
        }
        
        return $result;
    }
    
}
