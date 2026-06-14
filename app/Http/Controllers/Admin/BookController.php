<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function dashboard()
    {
        $totalBooks  = Book::count();
        $totalOrders = Order::count();
        $totalUsers  = User::where('role', 'user')->count();
        $revenue     = Order::where('status', 'delivered')->sum('total');
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $lowStock    = Book::where('stock', '<', 10)->where('is_active', true)->get();

        return view('admin.dashboard', compact(
            'totalBooks', 'totalOrders', 'totalUsers',
            'revenue', 'recentOrders', 'lowStock'
        ));
    }

    public function index()
    {
        $books = Book::all();
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        Book::create($data);
        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($book->image && $book->image !== 'default.jpg') {
                Storage::disk('public')->delete($book->image);
            }
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        // This completely removes the book row from your MySQL database table
        $book->delete(); 
        
        return back()->with('success', 'Book deleted successfully!');
    }

    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }
}