<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends ApiController
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $shoppingCarts = ShoppingCart::with('product', 'user')
                ->latest()
                ->paginate();

            return $this->success('Shopping carts fetched successfully', [
                'ShopppingCarts' => $shoppingCarts,
            ]);

        }

        $shoppingCarts = ShoppingCart::with('product', 'user')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate();

        return $this->success('Shopping carts fetched successfully', [
            'ShopppingCarts' => $shoppingCarts,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'exists:users,id'],
        ]);

        try {
            $shoppingCart = DB::transaction(function () use ($validated) {
                // check if the selected product is active
                $product = Product::with('shoppingCarts')
                    ->where('id', $validated['product_id'])
                    ->get();

                if ($product->status != 'active') {
                    throw Exception('The selected roduct is either inactive or banned');
                }

                // Calculate the total cost

                $productCost = $product->price * $validated['quantity'];

                return ShoppingCart::create(array_merge($validated, [
                    'total_cost' => $productCost,
                ]));
            });

            return $this->success('Product added to a cart succesfully', [
                'shoppingCart' => $shoppingCart,
            ]);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function show(ShoppingCart $shoppingCart)
    {
        $this->authorize('view', $shoppingCart);

        return $this->success('Cart fetched succesfully succesfully', [
            'shoppingCart' => $shoppingCart,
        ]);
    }

    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        $this->authorize('update', $shoppingCart);
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'exists:users,id'],
        ]);

        try {
            $shoppingCart = DB::transaction(function () use ($validated, $shoppingCart) {
                // check if the selected product is active
                $product = Product::with('shoppingCarts')
                    ->where('id', $validated['product_id'])
                    ->get();

                if ($product->status != 'active') {
                    throw Exception('The selected roduct is either inactive or banned');
                }

                // Calculate the total cost

                $productCost = $product->price * $validated['quantity'];

                $shoppingCart->update(array_merge($validated, [
                    'total_cost' => $productCost,
                ]));
            });

            return $this->success('Shopping cart updated successfully', [
                'shoppingCart' => $shoppingCart,
            ]);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function destroy(ShoppingCart $shoppingCart)
    {
        $this->authorize('delete', $shoppingCart);
        $shoppingCart->delete();

        return $this->success('Cart deleted successfully');
    }

    public function removeProduct(int $productId)
    {
        ShoppingCart::findOrFail($productId)->delete();

        return $this->success('product removed successfully successfully');
    }
}
