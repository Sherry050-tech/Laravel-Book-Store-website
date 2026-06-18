@extends('layouts.app')

@push('styles')
<style>
    .dash-wrap { max-width:900px; margin:40px auto; padding:0 24px; }
    .dash-header { background:linear-gradient(135deg,#111,#1a1a2e); color:#fff; border-radius:16px; padding:32px; margin-bottom:28px; }
    .dash-header h1 { font-size:26px; font-weight:700; margin-bottom:8px; }
    .dash-header p { color:#aaa; }
    .dash-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:28px; }
    .dash-card { background:#fff; border-radius:12px; padding:20px; text-align:center; box-shadow:0 1px 4px rgba(0,0,0,.08); }
    .dash-card .icon { font-size:32px; margin-bottom:8px; }
    .dash-card .val { font-size:24px; font-weight:700; margin-bottom:4px; }
    .dash-card .lbl { font-size:13px; color:#888; }
    .dash-card a { text-decoration:none; color:inherit; }
    
    .section-title { font-size:18px; font-weight:700; margin-bottom:16px; margin-top:32px;}
    
    .order-row { background:#fff; border-radius:10px; padding:16px 20px; margin-bottom:10px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 4px rgba(0,0,0,.06); }
    .order-row a { text-decoration:none; color:#111; font-weight:600; }
    .order-row a:hover { color:#e8c97e; }
    
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
    .badge-yellow { background:#fef3c7; color:#92400e; }
    .badge-blue   { background:#dbeafe; color:#1e40af; }
    .badge-purple { background:#ede9fe; color:#5b21b6; }
    .badge-green  { background:#d1fae5; color:#065f46; }
    .badge-red    { background:#fee2e2; color:#991b1b; }
    
    .quick-links { display:flex; gap:12px; flex-wrap:wrap; margin-top:24px; }
    .quick-link { padding:12px 20px; background:#fff; border-radius:10px; text-decoration:none; color:#111; font-size:14px; font-weight:500; box-shadow:0 1px 4px rgba(0,0,0,.08); display:flex; align-items:center; gap:8px; transition: all 0.2s; }
    .quick-link:hover { background:#111; color:#fff; }

    /* New Feedback Form Styles */
    .feedback-card { background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.08); }
    .form-label { display:block; font-size:14px; font-weight:600; margin-bottom:6px; color:#333; }
    .form-control { width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px; font-family:inherit; font-size:14px; margin-bottom:16px; transition: border-color 0.2s; }
    .form-control:focus { outline:none; border-color:#111; }
    .btn-submit { background:#e8c97e; color:#111; font-weight:700; padding:12px 24px; border:none; border-radius:8px; cursor:pointer; font-size:14px; transition: background 0.2s; }
    .btn-submit:hover { background:#d4b86a; }
</style>
@endpush

@section('content')
<div class="dash-wrap">
    <div class="dash-header">
        <h1>Welcome back, {{ auth()->user()->name }}! 👋</h1>
        <p>Here's your account overview</p>
    </div>
    
    <div class="dash-grid">
        <div class="dash-card">
            <div class="icon">📦</div>
            <div class="val">{{ auth()->user()->orders()->count() }}</div>
            <div class="lbl">Total Orders</div>
        </div>
        <div class="dash-card">
            <div class="icon">🛒</div>
            <div class="val">{{ $cartCount ?? 0 }}</div> 
            <div class="lbl">Cart Items</div>
        </div>
        <div class="dash-card">
            <div class="icon">✅</div>
            <div class="val">{{ auth()->user()->orders()->where('status','delivered')->count() }}</div>
            <div class="lbl">Delivered</div>
        </div>
    </div>

    <p class="section-title">Recent Orders</p>
    @forelse($orders as $order)
    <div class="order-row">
        <div>
            <a href="{{ route('orders.show', $order) }}">#{{ $order->id }} — {{ $order->created_at->format('M d, Y') }}</a>
            <p style="font-size:13px;color:#888;margin-top:4px;">{{ $order->items->count() }} items • ${{ number_format($order->total,2) }}</p>
        </div>
        <span class="badge badge-{{ $order->status === 'pending' ? 'yellow' : ($order->status === 'confirmed' ? 'blue' : ($order->status === 'shipped' ? 'purple' : ($order->status === 'delivered' ? 'green' : 'red'))) }}">
            {{ ucfirst($order->status) }}
        </span>
    </div>
    @empty
    <p style="color:#aaa;text-align:center;padding:40px; background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,.08);">
        No orders yet. <a href="{{ route('books.index') }}" style="color:#e8c97e; font-weight:600; text-decoration:none;">Start shopping!</a>
    </p>
    @endforelse

    <div class="quick-links">
        <a href="{{ route('books.index') }}" class="quick-link"><i class="fas fa-book"></i> Browse Books</a>
        <a href="{{ route('cart.index') }}" class="quick-link"><i class="fas fa-shopping-cart"></i> My Cart</a>
        <a href="{{ route('orders.index') }}" class="quick-link"><i class="fas fa-box"></i> All Orders</a>
        <a href="{{ route('profile') }}" class="quick-link"><i class="fas fa-user"></i> My Profile</a>
    </div>

    <p class="section-title" style="margin-top: 40px;">Leave Website Feedback</p>
    <div class="feedback-card">
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf
            
            <label class="form-label">Rate your experience (1-5)</label>
            <select name="rating" class="form-control" required>
                <option value="5">⭐⭐⭐⭐⭐ (5) - Excellent</option>
                <option value="4">⭐⭐⭐⭐ (4) - Very Good</option>
                <option value="3">⭐⭐⭐ (3) - Average</option>
                <option value="2">⭐⭐ (2) - Poor</option>
                <option value="1">⭐ (1) - Terrible</option>
            </select>
            
            <label class="form-label">Comments or Suggestions</label>
            <textarea name="comment" rows="4" class="form-control" placeholder="Tell us how we can improve your shopping experience..." required></textarea>
            
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane" style="margin-right: 6px;"></i> Submit Feedback
            </button>
        </form>
    </div>
</div>
@endsection