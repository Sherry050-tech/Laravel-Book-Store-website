@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 40px auto; padding: 0 24px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 800; margin: 0;">My Order History</h1>
        <a href="{{ route('user.dashboard') }}" style="color: #666; text-decoration: none; font-weight: 600;">
            &larr; Back to Dashboard
        </a>
    </div>

    <div style="background: #fff; border-radius: 12px; border: 1px solid #eaeaea; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        
        @if(isset($orders) && $orders->count() > 0)
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background: #f4f4f5; border-bottom: 2px solid #e5e7eb;">
                    <tr>
                        <th style="padding: 16px 24px; color: #374151;">Order ID</th>
                        <th style="padding: 16px 24px; color: #374151;">Date Placed</th>
                        <th style="padding: 16px 24px; color: #374151;">Total Amount</th>
                        <th style="padding: 16px 24px; color: #374151;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 16px 24px;"><strong>#{{ $order->id }}</strong></td>
                        <td style="padding: 16px 24px; color: #666;">{{ $order->created_at->format('M d, Y') }}</td>
                        <td style="padding: 16px 24px; font-weight: 600;">${{ number_format($order->total, 2) }}</td>
                        <td style="padding: 16px 24px;">
                            <span style="background: {{ $order->status === 'delivered' ? '#dcfce7' : ($order->status === 'pending' ? '#fef08a' : '#ede9fe') }}; color: {{ $order->status === 'delivered' ? '#166534' : ($order->status === 'pending' ? '#854d0e' : '#5b21b6') }}; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if(method_exists($orders, 'links'))
                <div style="padding: 20px; border-top: 1px solid #eee;">
                    {{ $orders->links() }}
                </div>
            @endif
            
        @else
            <div style="padding: 60px 20px; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 16px;">📦</div>
                <h3 style="font-size: 18px; color: #111; margin-bottom: 8px;">No orders found</h3>
                <p style="color: #666; margin-bottom: 24px;">You haven't placed any orders with us yet.</p>
                <a href="{{ route('home') }}" style="background: #111; color: #fff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#333'" onmouseout="this.style.background='#111'">
                    Start Shopping
                </a>
            </div>
        @endif
        
    </div>
</div>
@endsection