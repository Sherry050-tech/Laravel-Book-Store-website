@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>Manage Books</h1>
    <a href="{{ route('admin.books.create') }}" class="btn btn-gold"><i class="fas fa-plus"></i> Add New Book</a>
</div>

<div class="panel">
    <div class="panel-header">
        <h2>All Books ({{ method_exists($books, 'total') ? $books->total() : $books->count() }})</h2>
    </div>
    <table>
        <thead>
            <tr><th>Cover</th><th>Title & Author</th><th>Price</th><th>Category</th><th>Stock</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @foreach($books as $book)
        <tr>
            <td><img src="{{ asset('storage/'.$book->image) }}" class="book-thumb" onerror="this.src='https://via.placeholder.com/40x52?text=B'" alt="{{ $book->title }}"></td>
            <td>
                <strong>{{ $book->title }}</strong><br>
                <small style="color:#9ca3af">{{ $book->author }}</small>
            </td>
            <td><strong>${{ number_format($book->price,2) }}</strong></td>
            <td><span class="badge badge-blue">{{ ucfirst(str_replace('_',' ',$book->category)) }}</span></td>
            <td>
                <span class="badge {{ $book->stock > 10 ? 'badge-green' : ($book->stock > 0 ? 'badge-yellow' : 'badge-red') }}">
                    {{ $book->stock }}
                </span>
            </td>
            <td>
                <span class="badge {{ $book->is_active ? 'badge-green' : 'badge-red' }}">
                    {{ $book->is_active ? 'Active' : 'Hidden' }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{ route('admin.books.destroy', $book) }}" style="display:inline" onsubmit="return confirm('Remove this book from store?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    
    @if(method_exists($books, 'links'))
        <div style="padding:16px 20px;">{{ $books->links() }}</div>
    @endif
</div>
@endsection  