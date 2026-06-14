<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('book')->get();
        $subtotal  = $cartItems->sum(fn($item) => $item->book->price * $item->quantity);
        $shipping  = $subtotal >= 49 ? 0 : 4.99;
        $total     = $subtotal + $shipping;

        return view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request, Book $book)
    {
        $cartItem = CartItem::where('user_id', auth()->id())
                            ->where('book_id', $book->id)->first();
        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'quantity' => 1,
            ]);
        }

        if ($request->ajax()) {
            $count = auth()->user()->cartItems()->sum('quantity');
            return response()->json(['success' => true, 'cartCount' => $count]);
        }

        return back()->with('success', '"'.$book->title.'" added to cart!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:100']);
        $cartItem->update(['quantity' => $request->quantity]);

        if ($request->ajax()) {
            $cartItems = auth()->user()->cartItems()->with('book')->get();
            $subtotal  = $cartItems->sum(fn($i) => $i->book->price * $i->quantity);
            $shipping  = $subtotal >= 49 ? 0 : 4.99;
            return response()->json([
                'success'  => true,
                'subtotal' => number_format($subtotal, 2),
                'shipping' => number_format($shipping, 2),
                'total'    => number_format($subtotal + $shipping, 2),
                'lineTotal'=> number_format($cartItem->book->price * $request->quantity, 2),
            ]);
        }

        return back();
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        auth()->user()->cartItems()->delete();
        return back()->with('success', 'Cart cleared.');
    }
}