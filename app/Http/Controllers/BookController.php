<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function home()
    {
        $bestsellers = Book::active()->category('bestseller')->take(4)->get();
        $newReleases = Book::active()->category('new_release')->take(4)->get();
        $topRated    = Book::active()->category('top_rated')->take(4)->get();
        $popular     = Book::active()->category('popular')->take(4)->get();

        return view('home', compact('bestsellers', 'newReleases', 'topRated', 'popular'));
    }

    public function index(Request $request)
    {
        $query = Book::active();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('author', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $books = $query->paginate(12);
        return view('books.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function dashboard()
    {
        $orders = auth()->user()->orders()->latest()->take(5)->get();
        $cartCount = auth()->user()->cartItems()->count();
        return view('user.dashboard', compact('orders', 'cartCount'));
    }
}
