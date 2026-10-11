<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController
{
    private function getOrCreateCart(Request $request): Cart
    {
        return Cart::query()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);
    }

    public function show(Request $request)
    {
        $cart = $this->getOrCreateCart($request);

        $cart->load(['items.product.images']);

        // compute totals
        $itemsTotal = $cart->items->sum(function (CartItem $item) {
            return ((float) $item->unit_price) * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'data' => [
                'cart' => $cart,
                'subtotal' => $itemsTotal,
            ],
        ]);
    }

    public function addItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $validator->validate();

        $cart = $this->getOrCreateCart($request);

        $product = Product::query()->findOrFail($request->get('product_id'));

        if (! $product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available',
            ], 422);
        }

        $qty = (int) $request->get('quantity');
        if ($product->stock > 0 && ($qty > $product->stock)) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock',
            ], 422);
        }

        $cartItem = CartItem::query()->firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $qty;
        $cartItem->unit_price = (float) $product->price;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'data' => $cartItem->load('product.images'),
            'message' => 'Item added to cart',
        ]);
    }

    public function updateItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $validator->validate();

        $cart = $this->getOrCreateCart($request);

        $cartItem = CartItem::query()->where('cart_id', $cart->id)
            ->where('product_id', (int) $request->get('product_id'))
            ->firstOrFail();

        $cartItem->quantity = (int) $request->get('quantity');

        $product = Product::query()->findOrFail($cartItem->product_id);
        $cartItem->unit_price = (float) $product->price;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'data' => $cartItem->load('product.images'),
            'message' => 'Cart item updated',
        ]);
    }

    public function removeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
        ]);
        $validator->validate();

        $cart = $this->getOrCreateCart($request);

        CartItem::query()->where('cart_id', $cart->id)
            ->where('product_id', (int) $request->get('product_id'))
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart item removed',
        ]);
    }

    public function clear(Request $request)
    {
        $cart = $this->getOrCreateCart($request);
        $cart->items()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }
}

