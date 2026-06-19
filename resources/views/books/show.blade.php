@extends('layouts.app')

@push('styles')
<style>
    .book-detail { max-width:900px; margin:40px auto; padding:0 24px; display:grid; grid-template-columns:280px 1fr; gap:40px; }
    .book-img { width:100%; border-radius:12px; box-shadow:0 8px 32px rgba(0,0,0,.15); }
    .book-meta h1 { font-size:28px; font-weight:800; margin-bottom:8px; }
    .book-meta .author { font-size:16px; color:#888; margin-bottom:16px; }
    .stars { color:#e8c97e; font-size:18px; margin-bottom:16px; }
    .book-price { font-size:32px; font-weight:800; color:#111; margin-bottom:24px; }
    .book-desc { color:#555; line-height:1.7; margin-bottom:24px; font-size:15px; }
    .book-badge { display:inline-block; padding:4px 12px; background:#f3f4f6; border-radius:20px; font-size:12px; margin-bottom:20px; }
    .stock-info { font-size:14px; color:#888; margin-bottom:20px; }
    .stock-ok { color:#059669; }
    .stock-low { color:#d97706; }
    .stock-out { color:#ef4444; }
    .btn-large { padding:14px 32px; font-size:16px; font-weight:600; border-radius:10px; border:none; cursor:pointer; text-decoration:none; display:inline-block; }
    .btn-cart { background:#111; color:#fff; }
    .btn-cart:hover { background:#333; }

    @media (max-width: 768px) {
        .book-detail {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        .book-img {
            max-width: 300px;
            margin: 0 auto;
            display: block;
        }
    }
</style>
@endpush

@section('content')

<div class="book-detail">
    <div>
        <img src="{{ asset('storage/' . $book->image) }}"
             onerror="this.src='https://via.placeholder.com/280x360?text={{ urlencode($book->title) }}'"
             alt="{{ $book->title }}" class="book-img">
    </div>
    <div class="book-meta">
        <span class="book-badge">{{ ucfirst(str_replace('_',' ',$book->category)) }}</span>
        <h1>{{ $book->title }}</h1>
        <p class="author">by {{ $book->author }}</p>
        
        <div class="stars">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $book->rating) ★ @else ☆ @endif
            @endfor
            <span style="color:#888;font-size:14px;">({{ $book->rating }}/5)</span>
        </div>
        
        <p class="book-price">${{ number_format($book->price, 2) }}</p>
        <p class="book-desc">{{ $book->description ?: 'No description available.' }}</p>

        <p class="stock-info">
            @if($book->stock > 10)
                <span class="stock-ok">✅ In Stock ({{ $book->stock }} available)</span>
            @elseif($book->stock > 0)
                <span class="stock-low">⚠️ Only {{ $book->stock }} left!</span>
            @else
                <span class="stock-out">❌ Out of Stock</span>
            @endif
        </p>

        @auth
            @if(!auth()->user()->isAdmin() && $book->stock > 0)
                <form method="POST" action="{{ route('cart.add', $book) }}">
                    @csrf
                    <button type="submit" class="btn-large btn-cart">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-large btn-cart">Login to Buy</a>
        @endauth
    </div>
</div>

@if(!empty($recommendations))
    <div style="max-width:900px; margin: 40px auto; padding: 24px; border-top: 2px solid #eee;">
        <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 20px;">
            Similar Books
        </h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            @foreach($recommendations as $rec)
                <a href="{{ route('books.show', $rec['id']) }}" style="text-decoration: none; color: inherit;">
                    <div style="background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #eaeaea; box-shadow: 0 4px 6px rgba(0,0,0,0.02); transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                        <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #111;">
                            {{ $rec['title'] }}
                        </h4>
                        <p style="color: #666; font-size: 14px; margin-bottom: 0;">
                            By {{ $rec['author'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif

@endsection