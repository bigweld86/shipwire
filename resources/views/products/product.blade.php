@extends('layouts.app')

@section('content')

<h1 class="display-4" class="form-title">{{ ucfirst($type) }} Product</h1>
<hr>
@if ($type === 'add')
<form method="POST" action="/products">
@else
<form method="POST" action="/products/{{ $product->product_id }}">
@endif

    {{ csrf_field() }}

    @if ($type === 'edit')
    <input type="hidden" id="product-id" name="product_id" value="{{ old('product_id', $product->product_id ?? null)}}">
    @endif

    <div class="form-row">
        <div class="form-group col-sm-12">
            <label for="product-name">Name <span class="required-field">*</label></label>
            <input type="text" class="form-control" id="product-name" name="product_name" value="{{ old('product_name', $product->product_name ?? null)}}" placeholder="Enter Product Name...">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-sm-12">
            <label for="product-description">Description:</label>
            <textarea class="form-control" rows="10" name="product_description" id="product-description">{{ old('product_description', $product->product_description ?? null)}}</textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-sm-3">
            <label for="product-width">Width (In):</label>
            <input type="text" class="form-control" id="product-width" name="product_width" placeholder="Width" value="{{ old('product_width', $product->product_width ?? null)}}">
        </div>
        <div class="form-group col-sm-3">
            <label for="product-length">Length (In):</label>
            <input type="text" class="form-control" id="product-length" name="product_length" placeholder="Length" value="{{ old('product_length', $product->product_length ?? null)}}">
        </div>
        <div class="form-group col-sm-3">
            <label for="product-height">Height (In):</label>
            <input type="text" class="form-control" id="product-height" name="product_height" placeholder="Height" value="{{ old('product_height', $product->product_height ?? null)}}">
        </div>
        <div class="form-group col-sm-3">
            <label for="product-weight">Weight (lbs):</label>
            <input type="text" class="form-control" id="product-weight" name="product_weight" placeholder="Weight" value="{{ old('product_weight', $product->product_weight ?? null)}}">
        </div>
    </div>
  
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="product-price">Price (USD) <span class="required-field">*</label></label>
            <input type="text" class="form-control" id="product-price" name="product_price" placeholder="Price (USD)" value="{{ old('product_price', $product->product_price ?? null)}}">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="float-right">(<span class="required-field">*</span>) <i>Required Field</i></div><br>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            @if ($type === 'add')
            <button type="submit" class="btn btn-primary">Add Product</button>
            @elseif ($type === 'edit')
            <button type="submit" class="btn btn-primary">Update</button>
            @endif
        </div>
    </div>

</form>

@endsection