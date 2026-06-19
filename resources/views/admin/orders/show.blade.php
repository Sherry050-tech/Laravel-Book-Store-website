@extends('layouts.admin')

@section('content')
<div class="topbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Order #{{ $order->id }} Details</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">&larr; Back to Orders</a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    <div class="panel">
        <div class="panel-body" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background: #f4f4f5; border-bottom: 2px solid #e5e7eb;">
                    <tr>
                        <th style="padding: 16px;">Book</th>
                        <th style="padding: 16px;">Price</th>
                        <th style="padding: 16px;">Qty</th>
                        <th style="padding: 16px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 16px;"><strong>{{ $item->book->title ?? 'Deleted Book' }}</strong></td>
                        <td style="padding: 16px;">${{ number_format($item->price, 2) }}</td>
                        <td style="padding: 16px;">{{ $item->quantity }}</td>
                        <td style="padding: 16px;"><strong>${{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <div class="panel-body" style="padding: 20px;">
            <h3 style="margin-top: 0;">Order Summary</h3>
            <p><strong>Customer:</strong> {{ $order->user->name ?? 'Guest' }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
            <p><strong>Status:</strong> 
                <span class="badge" style="background: #eee; padding: 4px 8px; border-radius: 4px;">{{ ucfirst($order->status) }}</span>
            </p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
            <h2 style="margin: 0;">Total: ${{ number_format($order->total, 2) }}</h2>
        </div>
    </div>
</div>
@endsection