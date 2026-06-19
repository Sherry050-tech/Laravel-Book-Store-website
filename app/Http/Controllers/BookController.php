<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function home()
    {
        $bestsellers = Book::active()->category('bestseller')->take(4)->get();
        $newReleases = Book::active()->category('new_release')->take(4)->get();
        $topRated    = Book::active()->category('top_rated')->take(4)->get();
        $popular     = Book::active()->category('popular')->take(4)->get();

        $recommendations = [];

        // If the user is logged in, grab their personalized feed for the homepage
        if (auth()->check()) {
            try {
                $lastOrder = auth()->user()->orders()->latest()->first();
                if ($lastOrder && $lastOrder->items->count() > 0) {
                    $favoriteBookTitle = $lastOrder->items->first()->book->title ?? null;
                    
                    if ($favoriteBookTitle) {
                        $response = Http::timeout(2)->get('http://127.0.0.1:5000/recommend', [
                            'title' => $favoriteBookTitle
                        ]);

                        if ($response->successful()) {
                            $recommendations = $response->json();
                        }
                    }
                }
            } catch (\Exception $e) {
                $recommendations = [];
            }
        }

        return view('home', compact('bestsellers', 'newReleases', 'topRated', 'popular', 'recommendations'));
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
        $recommendations = [];

        try {
            $response = Http::timeout(2)->get('http://127.0.0.1:5000/recommend', [
                'title' => $book->title
            ]);

            if ($response->successful()) {
                $recommendations = $response->json();
            }
        } catch (\Exception $e) {
            $recommendations = [];
        }

        return view('books.show', compact('book', 'recommendations'));
    }

    public function dashboard()
    {
        $orders = auth()->user()->orders()->latest()->take(5)->get();
        $cartCount = auth()->user()->cartItems()->count();

        $personalRecommendations = [];
        $lastOrder = auth()->user()->orders()->latest()->first();
        $favoriteBookTitle = null;

        try {
            if ($lastOrder && $lastOrder->items->count() > 0) {
                $favoriteBookTitle = $lastOrder->items->first()->book->title ?? null;
            }
        } catch (\Exception $e) {
            $favoriteBookTitle = null; 
        }

        if ($favoriteBookTitle) {
            try {
                $response = Http::timeout(2)->get('http://127.0.0.1:5000/recommend', [
                    'title' => $favoriteBookTitle
                ]);

                if ($response->successful()) {
                    $personalRecommendations = $response->json();
                }
            } catch (\Exception $e) {
                $personalRecommendations = [];
            }
        }

        return view('user.dashboard', compact('orders', 'cartCount', 'personalRecommendations'));
    }
}