@extends('layouts.app')

@push('styles')
<style>
    .page-header { background:#111; color:#fff; padding:40px; }
    .page-header h1 { font-size:32px; font-weight:700; margin-bottom:8px; }
    .page-header p { color:#aaa; }

    .filter-bar {
        background:#f9fafb; padding:16px 40px;
        display:flex; gap:12px; align-items:center; flex-wrap:wrap;
        border-bottom:1px solid #eee;
    }
    .filter-bar input, .filter-bar select {
        padding:9px 14px; border:1px solid #ddd; border-radius:8px;
        font-size:14px; outline:none;
    }
    .filter-bar input { width:280px; }
    .btn-filter { background:#111; color:#fff; padding:9px 20px; border:none; border-radius:8px; cursor:pointer; font-size:14px; }

    .books-wrap { padding:40px; }
    .books-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(180px,1fr)); gap:20px; margin-bottom:32px; }

    .book-card { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.08); transition:transform .2s; }
    .book-card:hover { transform:translateY(-4px); }
    .book-cover { height:200px; overflow:hidden; background:#f3f4f6; }
    .book-cover img { width:100%; height:100%; object-fit:cover; }
    .book-info { padding:14px; }
    .book-title { font-size:14px; font-weight:600; margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .book-author { font-size:12px; color:#888; margin-bottom:8px; }
    .book-footer { display:flex; justify-content:space-between; align-items:center; }
    .book-price { font-size:15px; font-weight:700; }
    .btn-add { background:#111; color:#fff; border:none; padding:6px 12px; border-radius:6px; font-size:12px; cursor:pointer; }
    .stars { color:#e8c97e; font-size:12px; margin-bottom:6px; }
    .no-books { text-align:center; padding:80px 20px; color:#aaa; }
    .no-books i { font-size:60px; margin-bottom:16px; display:block; }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>All Books</h1>
    <p>Find your perfect read from our collection</p>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('books.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or author...">
        <select name="category">
            <option value="">All Categories</option>
            <option value="bestseller"  {{ request('category')=='bestseller'  ? 'selected':'' }}>Best Sellers</option>
            <option value="new_release" {{ request('category')=='new_release' ? 'selected':'' }}>New Releases</option>
            <option value="top_rated"   {{ request('category')=='top_rated'   ? 'selected':'' }}>Top Rated</option>
            <option value="popular"     {{ request('category')=='popular'     ? 'selected':'' }}>Popular</option>
            <option value="suggestion"  {{ request('category')=='suggestion'  ? 'selected':'' }}>Suggestions</option>
        </select>
        <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Search</button>
        @if(request('search') || request('category'))
            <a href="{{ route('books.index') }}" style="color:#888;font-size:13px;text-decoration:none;">Clear</a>
        @endif
    </form>
</div>

<div class="books-wrap">
    @if($books->count())
        <div class="books-grid">
            @foreach($books as $book)
                @include('books.card', ['book' => $book])
            @endforeach
        </div>
        {{ $books->withQueryString()->links() }}
    @else
        <div class="no-books">
            <i class="fas fa-book-open"></i>
            <h3>No books found</h3>
            <p>Try a different search or category</p>
        </div>
    @endif
</div>

@endsection