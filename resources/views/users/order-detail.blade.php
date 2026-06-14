@extends('layouts.app')

@push('styles')
<style>
    .wrap { max-width:800px; margin:40px auto; padding:0 24px; }
    .back-link { color:#888; text-decoration:none; font-size:14px; display:inline-block; margin-bottom:20px; }
    .order-header { background:#111; color:#fff; border-radius:12px; padding:24px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center; }
    .order-header h1 { font-size:22px; font-weight:700; }
    .badge { display:inline-block; padding:6px 16px; border-radius:20px; font-size:13px; font-weight:600; }
    .badge-yellow{background:#fef3c7;color:#92400e}
    .badge-blue{background:#dbeafe;color:#1e40af}
    .badge-purple{background:#ede9fe;color:#5b21b6}
    .badge-green{background:#d1fae5;color:#065f46}
    .badge-red{background:#fee2e2;color:#991b1b}
    .card { background:#fff; border-radius:12px; padding:20px; margin-bottom:16px; box-shadow:0 1px 4px rgba(0,0,0,.08); }
    .card h3 { font-size:15px; font-weight:600; margin-bottom:12px; color:#888; text-transform:uppercase; letter-spacing:.5px; font-size:12px; }
    .info-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f3f4f6; font-size:14px; }
    .info-row:last-child { border:none; }
    .item-row { display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #f3f4f6; }
    .item-row:last-child { border:none; }
    .item-title { font-weight:600; font-size:14px; }
    .item-author { font-size:12px; color:#888; }
    .total-row { display:flex; justify-content:space-between; padding:10px 0; font-size:14px; }
    .grand-total { font-size:18px; font-weight:700; border-top:2px solid #111; padding-top:12px; margin-top:4px; }
</style>
@endpush

@section('content')
<div class="wrap">
    <a href="{{ route('orders.index') }}" class="back-link">← Back to Orders</a>

    <div class="order-header">
        <div>
            <h1>Order #{{ $order->id }}</h1>
            <p style="color:#aaa;font-size:14px;margin-top:4px;">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>
        <span class="badge badge-{{ match($order->status){'pending'=>'yellow','confirmed'=>'blue','shipped'=>'purple','delivered'=>'green','cancelled'=>'red',default=>'gray'} }}">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div class="card">
        <h3>Delivery Info</h3>
        <div class="info-row"><span>Name</span><strong>{{ $order->customer_name }}</strong></div>
        <div class="info-row"><span>Email</span><strong>{{ $order->customer_email }}</strong></div>
        <div class="info-row"><span>Phone</span><strong>{{ $order->customer_phone ?: 'N/A' }}</strong></div>
        <div class="info-row"><span>Address</span><strong>{{ $order->address ?: 'N/A' }}</strong></div>
        <div class="info-row"><span>Payment</span><strong>{{ strtoupper($order->payment_method) }}</strong></div>
    </div>

    <div class="card">
        <h3>Items Ordered</h3>
        @foreach($order->items as $item)
        <div class="item-row">
            <div>
                <p class="item-title">{{ $item->title }}</p>
                <p class="item-author">{{ $item->author }}</p>
            </div>
            <div style="text-align:right;">
                <p style="font-size:14px;">${{ number_format($item->price,2) }} × {{ $item->quantity }}</p>
                <p style="font-weight:700;">${{ number_format($item->price * $item->quantity,2) }}</p>
            </div>
        </div>
        @endforeach

        <div class="total-row"><span>Subtotal</span><span>${{ number_format($order->subtotal,2) }}</span></div>
        <div class="total-row"><span>Shipping</span><span>{{ $order->shipping == 0 ? 'FREE' : '$'.number_format($order->shipping,2) }}</span></div>
        <div class="total-row grand-total"><span>Total</span><span>${{ number_format($order->total,2) }}</span></div>
    </div>
</div>
@endsection