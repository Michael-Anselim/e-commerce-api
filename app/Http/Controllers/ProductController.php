<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function index()
    {
        $products = Product::latest()->paginate();

        return $this->success('products fetchhed successfully', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer'],
            'price' => ['required', 'decimal:10,2'],
            'status' => ['required', 'string', 'in:active,inactive,banned'],
        ]);

        $product = Product::create($validated);

        return $this->success('Product addes successfully', [
            'product' => $product,
        ], 201);
    }

    public function show(Product $product)
    {
        return $this->success('product fetchhed successfully', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer'],
            'price' => ['required', 'decimal:10,2'],
            'status' => ['required', 'string', 'in:active,inactive,banned'],
        ]);
        $product->update($validated);

        return $this->success('product updated successfully', [
            'product' => $product,
        ]);

    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->success('product deleted successfully', [
            'product' => $product,
        ]);
    }
}
