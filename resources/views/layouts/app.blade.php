<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BookStore') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #fff; color: #111; }

        /* NAV */
        nav {
            background: #111;
            padding: 14px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .nav-logo { color: #fff; font-size: 22px; font-weight: 700; text-decoration: none; }
        .nav-logo span { color: #e8c97e; }
        .nav-links { display: flex; gap: 24px; align-items: center; }
        .nav-links a { color: #ccc; text-decoration: none; font-size: 14px; transition: color .2s; }
        .nav-links a:hover { color: #fff; }
        .nav-links a.active { color: #e8c97e; }
        .nav-cart { position: relative; color: #fff; font-size: 20px; text-decoration: none; }
        .cart-badge {
            position: absolute; top: -8px; right: -8px;
            background: #e8c97e; color: #111;
            border-radius: 50%; width: 18px; height: 18px;
            font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .btn-nav {
            padding: 8px 18px; border-radius: 8px;
            font-size: 13px; font-weight: 600;
            text-decoration: none; cursor: pointer; border: none;
        }
        .btn-nav-outline { border: 1px solid #555; color: #ccc; background: transparent; }
        .btn-nav-outline:hover { border-color: #e8c97e; color: #e8c97e; }
        .btn-nav-gold { background: #e8c97e; color: #111; }
        .btn-nav-gold:hover { background: #d4b86a; }

        /* FLASH MESSAGES */
        .flash { padding: 12px 20px; margin: 16px 40px; border-radius: 8px; font-size: 14px; }
        .flash-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .flash-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* FOOTER */
        footer { background: #111; color: #888; text-align: center; padding: 24px; font-size: 13px; margin-top: 60px; }
        footer span { color: #e8c97e; }
    </style>
    @stack('styles')
</head>
<body>

<nav>
    <a href="{{ route('home') }}" class="nav-logo">📚 Book<span>Store</span></a>
    <div class="nav-links">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">Books</a>

        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
            @else
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('cart.index') }}" class="nav-cart">
                    <i class="fas fa-shopping-cart"></i>
                    @php $cartCount = auth()->user()->cartItems()->sum('quantity') @endphp
                    @if($cartCount > 0)
                        <span class="cart-badge" id="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-nav btn-nav-outline">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-nav btn-nav-outline">Log In</a>
            <a href="{{ route('register') }}" class="btn-nav btn-nav-gold">Register</a>
        @endauth
    </div>
</nav>

@if(session('success'))
    <div class="flash flash-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash flash-error">❌ {{ session('error') }}</div>
@endif

@yield('content')

<footer>
    <p>© 2024 <span>BookStore</span>. All rights reserved.</p>
</footer>

@stack('scripts')
</body>
</html>