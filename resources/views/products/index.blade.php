@extends('layouts.app')

@section('content')

<h1>
    List of Products
    <a href="{{ action('ProductsController@create')}}" class="btn btn-success float-right">Add New Product</a>
</h1>
<br/>



<div class="table-responsive">
    <table class="table table-stripped products-table">
        <thead>
            <tr class="d-flex">
                <th scope="col" class="col-2">Name</th>
                <th scope="col" class="col-4">Description</th>
                <th scope="col" class="col-1">Price</th>
                <th scope="col" class="col-2">Measurements (WxWxH)</th>
                <th scope="col" class="col-1">Weight (lbs)</th>
                <th  scope="col" class="col-2">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($products as $product)
            <tr class="product-{{ $product['product_id'] }} d-flex product-list-row">
                <td class="col-2">{{ $product['product_name'] }}</td>
                <td class="col-4">{{ $product['product_description'] ?? '-' }}</td>
                <td class="col-1">$ {{ $product['product_price'] }}</td>
                <td class="col-2">{{ $product['product_width'] ?? '--' }} x {{ $product['product_length'] ?? '--' }} x {{ $product['product_height'] ?? '--' }}</td>
                <td class="col-1">{{ $product['product_weight'] ?? '-' }}</td>
                <td class="col-2 action-buttons">
                    <a href="{{ action('ProductsController@show', $product['product_id'])}}" class="oi action-icon view-icon" data-glyph="eye" data-toggle="popover" data-placement="top" data-content="View Product"></a>
                    <a href="{{ action('ProductsController@edit', $product['product_id'])}}" class="oi action-icon edit-icon" data-glyph="pencil" data-toggle="popover" data-placement="top" data-content="Edit Product"></a>
                    <a href="#" class="delete-product oi action-icon remove-icon" data-glyph="trash" data-product-id="{{ $product['product_id'] }}" data-toggle="popover" data-placement="top" data-content="Delete Product"></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection