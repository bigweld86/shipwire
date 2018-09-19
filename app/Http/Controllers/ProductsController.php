<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Database\QueryException;
use App\Exceptions\CreateProductErrorException;
use TheSeer\Tokenizer\Exception;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsController extends Controller
{
    public function index() : Object
    {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    public function store(Request $request) : Object
    {
        // validate data
        $request->validate([
            'product_name' => 'required',
            'product_price' => 'required|numeric',
            'product_width' => 'nullable|numeric',
            'product_length' => 'nullable|numeric',
            'product_height' => 'nullable|numeric',
            'product_weight' => 'nullable|numeric'
        ]);

        
        $product = Product::create([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_price' => $request->product_price,
            'product_width' => $request->product_width,
            'product_length' => $request->product_length,
            'product_height' => $request->product_height,
            'product_weight' => $request->product_weight
        ]);
        
        return redirect('products')->with('success', 'Product has been successfully added');

    }

    public function create() : Object
    {
        return view('products.product', ['type' => 'add']);
    }

    public function edit(Int $id) : Object
    {
        
        $type = 'edit';

        try {
            $product = Product::findOrfail($id);
            return view('products.product', ['type' => 'edit', 'product' => $product]);
        } catch(ModelNotFoundException $e) {
            return redirect('products')->with('error', 'Product does not exist');
        }
        
    }

    public function update(Int $id) : Object
    {
        // validate data
        request()->validate([
            'product_name' => 'required',
            'product_price' => 'required|numeric|gt:0',
            'product_width' => 'nullable|numeric',
            'product_length' => 'nullable|numeric',
            'product_height' => 'nullable|numeric',
            'product_weight' => 'nullable|numeric'
        ]);

        $product = Product::findOrfail($id);
        
        $product->update([
            'product_name' => request('product_name'),
            'product_description' => request('product_description'),
            'product_price' => request('product_price'),
            'product_width' => request('product_width'),
            'product_length' => request('product_length'),
            'product_height' => request('product_height'),
            'product_weight' => request('product_weight')
        ]);

        return redirect('products')->with('success', 'Product has been successfully updated');
    }

    public function show(Int $id) : Object
    {
        try {
            $product = Product::findOrfail($id);
            return view('products.show', ['product' => $product]);
        } catch(ModelNotFoundException $e) {
            return redirect('products')->with('error', 'Product does not exist');
        }
    }

    public function destroy(Int $id) : Object
    {
        try {
            $product = Product::findOrfail($id);
            $product->delete();
            return response()->json(['deleted' => true]);
        } catch(ModelNotFoundException $e) {
            return response()->json(['message' => 'Product Does Not Exists']);
        }
    }
}
