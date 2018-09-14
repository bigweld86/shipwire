<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{

    public function store(Request $request)
    {
        $product = Product::create([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_price' => $request->product_price,
            'product_width' => $request->product_width,
            'product_length' => $request->product_length,
            'product_height' => $request->product_height,
            'product_weight' => $request->product_weight
        ]);

        return redirect('products')->with('success', 'Product has been added');
    }
}
