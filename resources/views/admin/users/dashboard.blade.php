@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 40px auto; padding: 0 24px;">
    
    <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 30px;">My Dashboard</h1>

    <!-- Top Stat Cards -->
    <div style="display: flex; gap: 24px; margin-bottom: 40px;">
        <div style="flex: 1; background: #111; color: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h3 style="font-size: 16px; color: #aaa; margin-bottom: 8px;">Items in Cart</h3>
            <p style="font-size: 36px; font-weight: 800; margin: 0;">{{ $cartCount }}</p>
        </div>
        
        <div style="flex: 1; background: #fff; padding: 24px; border-radius: 12px; border: 1px solid #eaeaea; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <h3 style="font-size: 16px; color: #666; margin-bottom: 8px;">Total Orders</h3>
            <p style="font-size: 36px; font-weight: 800; margin: 0; color: #111;">{{ $orders->count() }}</p>
        </div>
    </div>

    <!-- 🤖 Personalized AI Recommendations -->
    @if(!empty($personalRecommendations))
        <div style="margin-bottom: 40px; border: 2px solid #e8c97e; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(232, 201, 126, 0.15);">
            <div style="background: #111; color: #e8c97e; padding: 16px 24px;">
                <h2 style="font-size: 18px; margin: 0; font-weight: 700;">
                    🤖 Inspired by your last order
                </h2>
            </div>
            <div style="background: #fff; padding: 24px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                    @foreach($personalRecommendations as $rec)
                        <a href="{{ route('books.show', $rec['id']) }}" style="text-decoration: none; color: inherit;">
                            <div style="padding: 16px; border: 1px solid #eee; border-radius: 8px; transition: all 0.2s; height: 100%;" onmouseover="this.style.borderColor='#e8c97e'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='#eee'; this.style.transform='translateY(0)';">
                                <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 6px; color: #111;">
                                    {{ $rec['title'] }}
                                </h4>
                                <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
                                    By {{ $rec['author'] }}
                                </p>
                                <span style="background: #f9f9f9; color: #111; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #ddd;">
                                    {{ $rec['match'] }}% Match
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Orders Table -->
    <div>
        <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 20px;">Recent Orders</h2>
        
        @if($orders->isEmpty())
            <div style="background: #f9f9f9; padding: 40px; text-align: center; border-radius: 12px; border: 1px dashed #ccc;">
                <p style="color: #666; font-size: 16px; margin: 0;">You haven't placed any orders yet.</p>
            </div>
        @else
            <div style="background: #fff; border-radius: 12px; border: 1px solid #eaeaea; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead style="background: #f4f4f5; border-bottom: 2px solid #e5e7eb;">
                        <tr>
                            <th style="padding: 16px 24px; color: #374151;">Order ID</th>
                            <th style="padding: 16px 24px; color: #374151;">Date</th>
                            <th style="padding: 16px 24px; color: #374151;">Total</th>
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
                                <span style="background: {{ $order->status === 'delivered' ? '#dcfce7' : '#ede9fe' }}; color: {{ $order->status === 'delivered' ? '#166534' : '#5b21b6' }}; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection