@extends('layouts.app')

@push('styles')
<style>
    .wrap { max-width:900px; margin:40px auto; padding:0 24px; }
    .page-title { font-size:26px; font-weight:700; margin-bottom:24px; }
    .order-card { background:#fff; border-radius:12px; padding:20px; margin-bottom:16px; box-shadow:0 1px 4px rgba(0,0,0,.08); }
    .order-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
    .order-id { font-weight:700; font-size:16px; }
    .order-date { font-size:13px; color:#888; }
    .order-info { display:flex; gap:24px; font-size:14px; color:#555; }
    .order-info strong { color:#111; }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
    .badge-yellow{background:#fef3c7;color:#92400e}
    .badge-blue{background:#dbeafe;color:#1e40af}
    .badge-purple{background:#ede9fe;color:#5b21b6}
    .badge-green{background:#d1fae5;color:#065f46}
    .badge-red{background:#fee2e2;color:#991b1b}
    .btn-sm { padding:6px 14px; border-radius:6px; font-size:13px; text-decoration:none; display:inline-block; }
    .btn-dark { background:#111; color:#fff; }
    .btn-danger-sm { background:#ef4444; color:#fff; border:none; cursor:pointer; }
</style>
@endpush

@section('content')
<div class="wrap">
    <h1 class="page-title">📦 My Orders</h1>

    @forelse($orders as $order)
    <div class="order-card">
        <div class="order-header">
            <div>
                <span class="order-id">Order #{{ $order->id }}</span>
                <span class="order-date"> — {{ $order->created_at->format('M d, Y') }}</span>
            </div>
            <span class="badge badge-{{ match($order->status){ 'pending'=>'yellow','confirmed'=>'blue','shipped'=>'purple','delivered'=>'green','cancelled'=>'red',default=>'gray'} }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        <div class="order-info">
            <span>Total: <strong>${{ number_format($order->total,2) }}</strong></span>
            <span>Payment: <strong>{{ strtoupper($order->payment_method) }}</strong></span>
        </div>
        <div style="margin-top:12px;display:flex;gap:8px;">
            <a href="{{ route('orders.show', $order) }}" class="btn-sm btn-dark">View Details</a>
            @if($order->status === 'pending')
            <form method="POST" action="{{ route('orders.cancel', $order) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-danger-sm" onclick="return confirm('Cancel this order?')">Cancel</button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:80px;color:#aaa;">
        <i class="fas fa-box-open" style="font-size:60px;margin-bottom:16px;display:block;"></i>
        <h3>No orders yet!</h3>
        <a href="{{ route('books.index') }}" style="color:#e8c97e;">Start shopping</a>
    </div>
    @endforelse

    {{ $orders->links() }}
</div>
@endsection