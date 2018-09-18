@extends('layouts.app')

@section('content')

<h1>Your Order</h1>

<form method="GET" action="/orders/checkout">

{{ csrf_field() }}

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
        <div class="order-box">
            <h3 class="order-box-title">Order Details</h3>
            @foreach ($orderDetails as $item)
            <div class="order-item">
                <div class="order-item-details">
                    <h3>{{ $item['product_details']['product_name'] }}</h3>
                    <p class="order-item-text">
                        Qty: {{ $item['orderitem_qty'] }} <br/>
                        Description: {{ $item['product_details']['product_description'] }}
                    </p>
                    <span class="order-item-price">${{ $item['orderitem_price'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
                    
        <!-- <a href="#" class="btn btn-primary btn-lg mb30">Continue To Checkout</a> -->
        <button type="submit" class="btn btn-primary btn-lg mb30">Continue To Checkout</button>
    </div>
            
    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
        <div class="widget">
            <h4 class="widget-title">Order Summary</h4>
            <div class="summary-block">
                <div class="summary-content">
                    <div class="summary-head"><h5 class="summary-title">Total</h5></div>
                    <div class="summary-price">
                        <p class="summary-text">{{ $order->order_total }}</p>
                        <span class="summary-small-text pull-right">You're lucky, we won't charge you taxes this time</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</form>

@endsection