<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product; // Add Product model for validation
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Add an item to the cart
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_requested' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);

        // Check if there is enough stock available
        if ($product->quantity < $request->quantity_requested) {
            return response()->json(['message' => 'Not enough stock available'], 400);
        }

        // Check if the product already exists in the cart
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // If it exists, increment the quantity
            $cartItem->quantity_requested += $request->quantity_requested;
            $cartItem->save();
        } else {
            // If it does not exist, create a new cart item
            $cartItem = Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity_requested' => $request->quantity_requested,
            ]);
        }

        return response()->json(['message' => 'Product added to cart', 'cart' => $cartItem]);
    }

    /**
     * View cart items
     */
    public function viewCart()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();


        $total = $cartItems->sum(fn($item) => $item->quantity_requested * $item->product->price);

        return response()->json([
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    /**
     * Update the quantity of a cart item
     */
    public function updateCart(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity_requested' => 'required|integer|min:0',
        ]);

        $cartItem = Cart::findOrFail($cartItemId);

        // Ensure the cart item belongs to the logged-in user
        if ($cartItem->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product = Product::find($cartItem->product_id);

        // Check if there is enough stock for the updated quantity
        if ($product->quantity < $request->quantity_requested) {
            return response()->json(['message' => 'Not available'], 400);
        }

        $cartItem->update(['quantity_requested' => $request->quantity_requested]);

        return response()->json(['message' => 'Cart updated', 'cartItem' => $cartItem]);
    }

    /**
     * Remove an item from the cart
     */
    public function removeItem($cartItemId)
    {
        
        $cartItem = Cart::findOrFail($cartItemId);

        // Ensure the cart item belongs to the logged-in user
        if ($cartItem->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }

    /**
     * Clearning the cart when chhecking out
     */
    public function clearCart()
    {
        Cart::where('user_id', auth()->id())->delete();
        
        return response()->json(['message' => 'Cart cleared']);
    }
}
