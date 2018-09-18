@extends('layouts.app')

@section('content')
<form method="POST" action="/orders/">

{{ csrf_field() }}

<input type="hidden" name="product_id" value="{{ $product->product_id }}" >

<div class="form-row">
        <div class="form-group col-sm-12">
            <label for="product-name">Name:</label>
            <input type="text" class="form-control form-control-plaintext" id="product-name" name="product_name" value="{{ $product->product_name }}" readonly">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-sm-12">
            <label for="product-description">Description:</label>
            <textarea class="form-control form-control-plaintext" rows="10" name="product_description" id="product-description" readonly>{{ $product->product_description }}</textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-sm-3">
            <label for="product-width">Width (In):</label>
            <input type="text" class="form-control form-control-plaintext" id="product-width" name="product_width" readonly value="{{ $product->product_width }}">
        </div>
        <div class="form-group col-sm-3">
            <label for="product-length">Length (In):</label>
            <input type="text" class="form-control form-control-plaintext" id="product-length" name="product_length" readonly value="{{ $product->product_length }}">
        </div>
        <div class="form-group col-sm-3">
            <label for="product-height">Height (In):</label>
            <input type="text" class="form-control form-control-plaintext" id="product-height" name="product_height" readonly value="{{ $product->product_height }}">
        </div>
        <div class="form-group col-sm-3">
            <label for="product-weight">Weight (lbs):</label>
            <input type="text" class="form-control form-control-plaintext" id="product-weight" name="product_weight" readonly value="{{ $product->product_weight }}">
        </div>
    </div>
  
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="product-price">Price (USD)</label>
            <input type="text" class="form-control form-control-plaintext" id="product-price" name="product_price" readonly value="{{ $product->product_price }}">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Add to Cart</button>
</div>
</form>

@endsection