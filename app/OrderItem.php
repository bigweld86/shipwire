<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Product;
use phpDocumentor\Reflection\Types\Boolean;

class OrderItem extends Model
{
    protected $primaryKey = 'orderitem_id';
    protected $table = 'orderitems';

    protected $fillable = [
        'orderitem_order_id',
        'orderitem_product_id',
        'orderitem_price',
        'orderitem_qty'
    ];

    public function order() : Object
    {
        return $this->belongsTo(Order::class);
    }

    public function updateQty() : void
    {   
        $this->update(['orderitem_qty' => ++$this->orderitem_qty]);
    }
}
