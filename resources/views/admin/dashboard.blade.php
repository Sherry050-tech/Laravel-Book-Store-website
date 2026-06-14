@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>Dashboard</h1>
    <a href="{{ route('admin.books.create') }}" class="btn btn-gold"><i class="fas fa-plus"></i> Add Book</a>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#ede9fe;color:#7c3aed"><i class="fas fa-book"></i></div>
        <div><p class="stat-label">Total Books</p><p class="stat-value">{{ $totalBooks }}</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#d1fae5;color:#059669"><i class="fas fa-shopping-bag"></i></div>
        <div><p class="stat-label">Total Orders</p><p class="stat-value">{{ $totalOrders }}</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dbeafe;color:#1d4ed8"><i class="fas fa-users"></i></div>
        <div><p class="stat-label">Total Users</p><p class="stat-value">{{ $totalUsers }}</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="fas fa-dollar-sign"></i></div>
        <div><p class="stat-label">Revenue</p><p class="stat-value">${{ number_format($revenue, 0) }}</p></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;">
    <div class="panel">
        <div class="panel-header">
            <h2>Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        <table>
            <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
            @forelse($recentOrders as $order)
            <tr>
                <td><a href="{{ route('admin.orders.show', $order) }}" style="text-decoration:none;font-weight:600;">#{{ $order->id }}</a></td>
                <td>{{ $order->customer_name }}<br><small style="color:#9ca3af">{{ $order->customer_email }}</small></td>
                <td><strong>${{ number_format($order->total,2) }}</strong></td>
                <td><span class="badge badge-{{ match($order->status){'pending'=>'yellow','confirmed'=>'blue','shipped'=>'purple','delivered'=>'green','cancelled'=>'red',default=>'gray'} }}">{{ ucfirst($order->status) }}</span></td>
                <td style="color:#9ca3af;font-size:13px">{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#aaa;padding:32px;">No orders yet</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="panel">
        <div class="panel-header"><h2>⚠️ Low Stock</h2></div>
        <div class="panel-body">
            @forelse($lowStock as $book)
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f3f4f6;font-size:13px;">
                <span>{{ Str::limit($book->title, 25) }}</span>
                <span class="badge badge-red">{{ $book->stock }} left</span>
            </div>
            @empty
            <p style="color:#aaa;font-size:14px;">All books are well stocked ✅</p>
            @endforelse
        </div>
    </div>
</div>
@endsection