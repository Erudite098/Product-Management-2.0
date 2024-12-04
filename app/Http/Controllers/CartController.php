<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product; // Add Product model for validation
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add item to the cart
    public function addItemToCart(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'product_name' => 'required|string|max:255|exists:products,name', // Validate that the product exists
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'cart_id' => 'required|exists:carts,id', // Ensure cart exists
        ]);

        // Ensure the cart belongs to the authenticated user
        $cart = Cart::where('user_id', Auth::id())->findOrFail($validated['cart_id']);

        // Calculate total price
        $totalPrice = $validated['price'] * $validated['quantity'];

        // Create the cart item
        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_name' => $validated['product_name'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
        ]);

        return response()->json([
            'message' => 'Item added to cart successfully.',
            'cart_item' => $cartItem
        ], 201);
    }

    // Update cart item quantity
    public function updateItemQuantity(Request $request, $cartItemId)
    {
        // Validate the request data
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the cart item
        $cartItem = CartItem::findOrFail($cartItemId);

        // Ensure the cart item belongs to the authenticated user
        $cart = Cart::where('user_id', Auth::id())->findOrFail($cartItem->cart_id);

        // Update quantity and total price
        $cartItem->quantity = $validated['quantity'];
        $cartItem->total_price = $cartItem->price * $validated['quantity'];
        $cartItem->save();

        return response()->json([
            'message' => 'Cart item updated successfully.',
            'cart_item' => $cartItem
        ]);
    }

    // Remove item from the cart
    public function removeItemFromCart($cartItemId)
    {
        // Find the cart item
        $cartItem = CartItem::findOrFail($cartItemId);

        // Ensure the cart item belongs to the authenticated user
        $cart = Cart::where('user_id', Auth::id())->findOrFail($cartItem->cart_id);

        // Delete the cart item
        $cartItem->delete();

        return response()->json([
            'message' => 'Item removed from cart successfully.'
        ]);
    }

    // View items in a cart
    public function viewCartItems($cartId)
    {
        // Ensure the cart belongs to the authenticated user
        $cart = Cart::where('user_id', Auth::id())->findOrFail($cartId);

        // Get all cart items for the specified cart
        $cartItems = CartItem::where('cart_id', $cartId)->get();

        return response()->json([
            'cart_items' => $cartItems
        ]);
    }
}
