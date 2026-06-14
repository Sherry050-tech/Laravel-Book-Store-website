<div class="book-card">
    <a href="{{ route('books.show', $book) }}" style="text-decoration:none;color:inherit;">
        <div class="book-cover">
            <img src="{{ asset('storage/' . $book->image) }}"
                 onerror="this.src='https://via.placeholder.com/180x200?text=Book'"
                 alt="{{ $book->title }}">
        </div>
        <div class="book-info">
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $book->rating)★@else☆@endif
                @endfor
            </div>
            <p class="book-title">{{ $book->title }}</p>
            <p class="book-author">{{ $book->author }}</p>
            <div class="book-footer">
                <span class="book-price">${{ number_format($book->price, 2) }}</span>
                @auth
                    @if(!auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('cart.add', $book) }}">
                            @csrf
                            <button type="submit" class="btn-add">+ Cart</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-add">+ Cart</a>
                @endauth
            </div>
        </div>
    </a>
</div>