@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>Manage Inventory</h1>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Book
    </a>
</div>

<div class="panel">
    <div class="panel-body" style="padding: 0;">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="background: #f1f1f1; border-bottom: 2px solid #ccc;">
                    <th style="padding: 12px 20px;">ID</th>
                    <th style="padding: 12px 20px;">Book Details</th>
                    <th style="padding: 12px 20px;">Price</th>
                    <th style="padding: 12px 20px;">Stock</th>
                    <th style="padding: 12px 20px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px 20px; color: #666;">#{{ $book->id }}</td>
                    <td style="padding: 12px 20px;">
                        <strong>{{ $book->title }}</strong><br>
                        <span style="color: #666; font-size: 13px;">{{ $book->author }}</span>
                    </td>
                    <td style="padding: 12px 20px;">${{ number_format($book->price, 2) }}</td>
                    <td style="padding: 12px 20px;">
                        @if($book->stock > 0)
                            <span class="badge badge-green">{{ $book->stock }} in stock</span>
                        @else
                            <span class="badge badge-red">Out of Stock</span>
                        @endif
                    </td>
                    <td style="padding: 12px 20px; display: flex; gap: 8px;">
                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline">Edit</a>
                        
                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #888;">
                        No books in the inventory yet. Click "Add New Book" to get started!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection