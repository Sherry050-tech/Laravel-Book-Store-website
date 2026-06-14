<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('user.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('items');
        return view('user.order-detail', compact('order'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:20',
            'address'        => 'required|string',
            'payment_method' => 'required|in:cod,card',
        ]);

        $cartItems = auth()->user()->cartItems()->with('book')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        $subtotal = $cartItems->sum(fn($i) => $i->book->price * $i->quantity);
        $shipping = $subtotal >= 49 ? 0 : 4.99;
        $total    = $subtotal + $shipping;

        $order = Order::create([
            'user_id'        => auth()->id(),
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'address'        => $request->address,
            'subtotal'       => $subtotal,
            'shipping'       => $shipping,
            'total'          => $total,
            'payment_method' => $request->payment_method,
            'status'         => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id'  => $item->book_id,
                'title'    => $item->book->title,
                'author'   => $item->book->author,
                'price'    => $item->book->price,
                'quantity' => $item->quantity,
            ]);
            $item->book->decrement('stock', $item->quantity);
        }

        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }

    public function cancel(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if($order->status !== 'pending', 403);
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Order cancelled.');
    }

    public function profile()
    {
        return view('user.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        auth()->user()->update($request->only('name', 'phone', 'address'));
        return back()->with('success', 'Profile updated!');
    }
}
