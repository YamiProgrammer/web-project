<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch orders where the retailer_id matches the authenticated user's id
        $orders = Order::where('retailer_id', auth()->id())->get();

        // Return the view with the orders
        return view('retailer.orders', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'productID' => 'required|exists:products,productID',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->productID);

        if ($request->quantity > $product->AvailableStocks) {
            return back()->with('error', 'Not enough stock available.');
        }

        Order::create([
            'productID' => $request->productID,
            'quantity' => $request->quantity,
            'retailer_id' => auth()->id(), // Assuming the retailer is logged in
        ]);

        $product->decrement('AvailableStocks', $request->quantity);

        return back()->with('success', 'Order placed successfully.');
    }

    public function checkout()
        {
            $carts = Cart::where('retailer_id', auth()->id())->get();

            foreach ($carts as $cart) {
                Order::create([
                    'retailer_id' => auth()->id(),
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'status' => 'pending', // or any other status
                ]);

                $cart->delete(); // Remove item from cart after creating order
            }

            return redirect()->route('retailer.orders')->with('success', 'Order placed successfully.');
        }
}
