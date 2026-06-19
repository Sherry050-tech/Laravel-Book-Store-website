@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto 40px auto; padding: 0 24px;">
    <div style="background: #111; color: #fff; padding: 60px 24px; text-align: center; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <h1 style="font-size: 42px; font-weight: 800; margin-bottom: 16px; color: #e8c97e;">
            Welcome to the Bookstore
        </h1>
        <p style="font-size: 18px; color: #aaa; max-width: 600px; margin: 0 auto 30px auto; line-height: 1.6;">
            Discover your next great read. From trending bestsellers to hidden gems, our AI-powered shelves have something just for you.
        </p>
        <a href="{{ route('books.index') }}" style="background: #e8c97e; color: #111; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 800; font-size: 16px; display: inline-block; transition: background 0.2s;" onmouseover="this.style.background='#d4b56a'" onmouseout="this.style.background='#e8c97e'">
            Browse All Books
        </a>
    </div>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">

    @if(isset($recommendations) && !empty($recommendations))
        <div style="margin-bottom: 60px; padding: 24px; background: #fdfbf7; border-radius: 16px; border: 1px solid #f3e8d2;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; border-bottom: 2px solid #e8c97e; padding-bottom: 12px;">
                <h2 style="font-size: 24px; font-weight: 800; margin: 0; color: #111;">Recommended for You</h2>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 24px;">
                @foreach($recommendations as $rec)
                    <a href="{{ route('books.show', $rec['id']) }}" style="text-decoration: none; color: inherit;">
                        <div style="background: #fff; border: 1px solid #eaeaea; border-radius: 12px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; height: 100%; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.borderColor='#e8c97e';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#eaeaea';">
                            <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: center;">
                                <h3 style="font-size: 16px; font-weight: 700; margin: 0 0 8px 0; color: #111; line-height: 1.3;">
                                    {{ $rec['title'] }}
                                </h3>
                                <p style="color: #666; font-size: 14px; margin: 0 0 16px 0;">{{ $rec['author'] }}</p>
                                <div>
                                    <span style="background: #e8c97e; color: #111; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 700;">
                                        Top Match
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    @php
        $shelves = [
            '🔥 Bestsellers' => $bestsellers ?? collect(),
            '✨ New Releases' => $newReleases ?? collect(),
            '⭐ Top Rated' => $topRated ?? collect(),
            '📈 Popular Picks' => $popular ?? collect()
        ];
    @endphp

    @foreach($shelves as $title => $books)
        @if($books->isNotEmpty())
            <div style="margin-bottom: 60px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; border-bottom: 2px solid #eee; padding-bottom: 12px;">
                    <h2 style="font-size: 24px; font-weight: 800; margin: 0; color: #111;">{{ $title }}</h2>
                    <a href="{{ route('books.index', ['category' => strtolower(str_replace([' ', '🔥', '✨', '⭐', '📈'], ['_', '', '', '', ''], $title))]) }}" style="color: #666; font-size: 14px; font-weight: 600; text-decoration: none;">
                        View All &rarr;
                    </a>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 24px;">
                    @foreach($books as $book)
                        <a href="{{ route('books.show', $book) }}" style="text-decoration: none; color: inherit;">
                            <div style="background: #fff; border: 1px solid #eaeaea; border-radius: 12px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; height: 100%; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'; this.style.borderColor='#e8c97e';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#eaeaea';">
                                
                                <div style="height: 280px; background: #f9f9f9; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    <img src="{{ asset('storage/' . $book->image) }}" 
                                         onerror="this.src='https://via.placeholder.com/220x280?text={{ urlencode($book->title) }}'" 
                                         alt="{{ $book->title }}" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                
                                <div style="padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <h3 style="font-size: 16px; font-weight: 700; margin: 0 0 6px 0; color: #111; line-height: 1.3;">
                                            {{ \Illuminate\Support\Str::limit($book->title, 40) }}
                                        </h3>
                                        <p style="color: #666; font-size: 14px; margin: 0 0 16px 0;">{{ $book->author }}</p>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-weight: 800; color: #111; font-size: 18px;">${{ number_format($book->price, 2) }}</span>
                                        <span style="background: #fdfbf7; color: #d97706; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 700;">
                                            ★ {{ $book->rating }}
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

</div>
@endsection