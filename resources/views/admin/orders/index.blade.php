@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>Manage Orders</h1>
</div>

<div class="panel">
    <div class="panel-body" style="padding: 0;">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="background: #f1f1f1; border-bottom: 2px solid #ccc;">
                    <th style="padding: 12px 20px;">Order ID</th>
                    <th style="padding: 12px 20px;">Customer</th>
                    <th style="padding: 12px 20px;">Total</th>
                    <th style="padding: 12px 20px;">Status</th>
                    <th style="padding: 12px 20px;">Date</th>
                    <th style="padding: 12px 20px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px 20px;"><strong>#{{ $order->id }}</strong></td>
                    <td style="padding: 12px 20px;">
                        <strong>{{ $order->user->name ?? 'Guest User' }}</strong><br>
                        <span style="color: #666; font-size: 13px;">{{ $order->user->email ?? '' }}</span>
                    </td>
                    <td style="padding: 12px 20px;">${{ number_format($order->total, 2) }}</td>
                    <td style="padding: 12px 20px;">
                        <span class="badge badge-{{ $order->status === 'pending' ? 'yellow' : ($order->status === 'confirmed' ? 'blue' : ($order->status === 'shipped' ? 'purple' : ($order->status === 'delivered' ? 'green' : 'red'))) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="padding: 12px 20px; color: #666; font-size: 13px;">{{ $order->created_at->format('M d, Y') }}</td>
                    <td style="padding: 12px 20px; display: flex; gap: 8px; align-items: center;">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline">View</a>
                        
                        <form action="{{ route('admin.orders.status', $order) }}" method="POST" style="display:flex; gap:4px; margin:0;">
                            @csrf 
                            @method('PATCH')
                            <select name="status" class="form-control" style="padding: 4px; height: auto; min-width: 100px;" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: #888;">
                        No orders have been placed yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection