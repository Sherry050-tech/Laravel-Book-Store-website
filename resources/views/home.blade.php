@extends('layouts.app')

@push('styles')
<style>
    .hero {
        background: linear-gradient(135deg, #111 0%, #1a1a2e 100%);
        color: #fff; padding: 80px 40px; text-align: center;
    }
    .hero h1 { font-size: 48px; font-weight: 800; margin-bottom: 16px; }
    .hero h1 span { color: #e8c97e; }
    .hero p { font-size: 18px; color: #aaa; margin-bottom: 32px; }
    .hero-btns { display:flex; gap:16px; justify-content:center; flex-wrap:wrap; }
    .btn-hero-gold { background:#e8c97e; color:#111; padding:14px 32px; border-radius:10px; font-size:16px; font-weight:700; text-decoration:none; }
    .btn-hero-outline { border:2px solid #555; color:#fff; padding:14px 32px; border-radius:10px; font-size:16px; text-decoration:none; }
    .btn-hero-gold:hover { background:#d4b86a; }
    .btn-hero-outline:hover { border-color:#e8c97e; color:#e8c97e; }

    .section { padding: 60px 40px; }
    .section-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; }
    .section-header h2 { font-size:24px; font-weight:700; }
    .section-header a { color:#e8c97e; text-decoration:none; font-size:14px; }

    .books-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(180px, 1fr)); gap:20px; }
    .book-card {
        background:#fff; border-radius:12px; overflow:hidden;
        box-shadow:0 2px 8px rgba(0,0,0,.08); transition:transform .2s, box-shadow .2s;
        cursor:pointer;
    }
    .book-card:hover { transform:translateY(-4px); box-shadow:0 8px 24px rgba(0,0,0,.12); }
    .book-cover { height:200px; overflow:hidden; background:#f3f4f6; position:relative; }
    .book-cover img { width:100%; height:100%; object-fit:cover; }
    .book-info { padding:14px; }
    .book-title { font-size:14px; font-weight:600; margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .book-author { font-size:12px; color:#888; margin-bottom:8px; }
    .book-footer { display:flex; justify-content:space-between; align-items:center; }
    .book-price { font-size:15px; font-weight:700; color:#111; }
    .btn-add {
        background:#111; color:#fff; border:none; padding:6px 12px;
        border-radius:6px; font-size:12px; cursor:pointer; text-decoration:none;
    }
    .btn-add:hover { background:#333; }

    .stars { color:#e8c97e; font-size:12px; margin-bottom:6px; }
</style>
@endpush

@section('content')

<!-- Hero -->
<div class="hero">
    <h1>Discover Your Next<br><span>Favourite Book</span></h1>
    <p>Thousands of books, one destination. Find your perfect read today.</p>
    <div class="hero-btns">
        <a href="{{ route('books.index') }}" class="btn-hero-gold">Browse Books</a>
        @guest
            <a href="{{ route('register') }}" class="btn-hero-outline">Create Account</a>
        @endguest
    </div>
</div>

<!-- Bestsellers -->
<div class="section">
    <div class="section-header">
        <h2>🔥 Best Sellers</h2>
        <a href="{{ route('books.index', ['category' => 'bestseller']) }}">View All →</a>
    </div>
    <div class="books-grid">
        @foreach($bestsellers as $book)
            @include('books.card', ['book' => $book])
        @endforeach
    </div>
</div>

<!-- New Releases -->
<div class="section" style="background:#f9fafb;">
    <div class="section-header">
        <h2>🆕 New Releases</h2>
        <a href="{{ route('books.index', ['category' => 'new_release']) }}">View All →</a>
    </div>
    <div class="books-grid">
        @foreach($newReleases as $book)
            @include('books.card', ['book' => $book])
        @endforeach
    </div>
</div>

<!-- Top Rated -->
<div class="section">
    <div class="section-header">
        <h2>⭐ Top Rated</h2>
        <a href="{{ route('books.index', ['category' => 'top_rated']) }}">View All →</a>
    </div>
    <div class="books-grid">
        @foreach($topRated as $book)
            @include('books.card', ['book' => $book])
        @endforeach
    </div>
</div>

<!-- Popular -->
<div class="section" style="background:#f9fafb;">
    <div class="section-header">
        <h2>📈 Most Popular</h2>
        <a href="{{ route('books.index', ['category' => 'popular']) }}">View All →</a>
    </div>
    <div class="books-grid">
        @foreach($popular as $book)
            @include('books.card', ['book' => $book])
        @endforeach
    </div>
</div>

@endsection