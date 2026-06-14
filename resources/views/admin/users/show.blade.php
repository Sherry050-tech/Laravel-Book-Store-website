@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>User: {{ $user->name }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:300px 1fr;gap:20px;">
    <div class="panel" style="height:fit-content;">
        <div class="panel-body" style="text-align:center;">
            <div style="width:80px;height:80px;background:#111;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;color:#e8c97e;margin:0 auto 12px;">
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>
            <h3>{{ $user->name }}</h3>
            <p style="color:#888;font-size:13px;margin-top:4px;">{{ $user->email }}</p>
            <p style="margin-top:8px;font-size:13px;">{{ $user->phone ?: 'No phone' }}</p>
            <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-red' }}" style="margin-top:12px;">
                {{ $user->is_active ? 'Active' : 'Blocked' }}
            </span>
            <p style="color:#9ca3af;font-size:12px;margin-top:12px;">Joined {{ $user->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header"><h2>Order History</h2></div>
        <table>
            <thead><tr><th>Order #</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
            @forelse($user->orders as $order)
            <tr>
                <td><a href="{{ route('admin.orders.show', $order) }}" style="text-decoration:none;font-weight:600;">#{{ $order->id }}</a></td>
                <td>${{ number_format($order->total,2) }}</td>
                <td><span class="badge badge-{{ match($order->status){'pending'=>'yellow','confirmed'=>'blue','shipped'=>'purple','delivered'=>'green','cancelled'=>'red',default=>'gray'} }}">{{ ucfirst($order->status) }}</span></td>
                <td style="font-size:13px;color:#9ca3af">{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:32px;color:#aaa;">No orders yet</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection