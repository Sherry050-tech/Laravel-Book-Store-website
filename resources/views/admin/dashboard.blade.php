@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>Admin Dashboard</h1>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#dbeafe; color:#1e40af;">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <div class="stat-label">Total Books</div>
            <div class="stat-value">120</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#d1fae5; color:#065f46;">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">45</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7; color:#92400e;">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value">32</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#ede9fe; color:#5b21b6;">
            <i class="fas fa-star"></i>
        </div>
        <div>
            <div class="stat-label">Feedbacks</div>
            <div class="stat-value">12</div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h2>Welcome to the Admin Panel</h2>
    </div>
    <div class="panel-body">
        <p style="color: #6b7280; line-height: 1.6;">
            Your dashboard is fully connected. From the sidebar menu on the left, you can manage your bookstore's inventory, process incoming user orders, manage registered accounts, and read customer feedback.
        </p>
        <br>
        <a href="{{ route('admin.books.index') }}" class="btn btn-gold">Manage Inventory</a>
    </div>
</div>
@endsection