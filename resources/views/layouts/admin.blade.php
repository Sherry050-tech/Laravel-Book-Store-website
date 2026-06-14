<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif; background:#f3f4f6; display:flex; min-height:100vh; }

        .sidebar {
            width: 240px; background: #111; color: #fff;
            display: flex; flex-direction: column;
            position: fixed; top:0; left:0; height:100vh; z-index:100;
        }
        .sidebar-logo { padding: 24px 20px; font-size: 18px; font-weight: 700; border-bottom: 1px solid #222; }
        .sidebar-logo span { color: #e8c97e; }
        .sidebar nav { flex:1; padding: 16px 0; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 20px; color: #aaa; text-decoration: none;
            font-size: 14px; border-left: 3px solid transparent;
            transition: all .2s;
        }
        .nav-item:hover, .nav-item.active {
            background: #1a1a1a; color: #fff; border-left-color: #e8c97e;
        }
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid #222; }
        .sidebar-footer a { color: #666; font-size: 13px; text-decoration: none; }
        .sidebar-footer a:hover { color: #fff; }

        .main { margin-left: 240px; flex:1; padding: 28px; }

        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
        .topbar h1 { font-size: 22px; font-weight: 700; }

        /* Cards */
        .stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
        .stat-card {
            background:#fff; border-radius:12px; padding:20px;
            display:flex; align-items:center; gap:16px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
        }
        .stat-icon { width:48px; height:48px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:20px; }
        .stat-label { font-size:12px; color:#6b7280; margin-bottom:4px; }
        .stat-value { font-size:24px; font-weight:700; }

        /* Panel */
        .panel { background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.08); margin-bottom:24px; overflow:hidden; }
        .panel-header { display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid #f3f4f6; }
        .panel-header h2 { font-size:15px; font-weight:600; }
        .panel-body { padding:20px; }

        /* Table */
        table { width:100%; border-collapse:collapse; font-size:14px; }
        th { background:#f9fafb; padding:10px 14px; text-align:left; font-size:12px; color:#6b7280; text-transform:uppercase; letter-spacing:.5px; }
        td { padding:12px 14px; border-bottom:1px solid #f3f4f6; vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:#fafafa; }

        /* Buttons */
        .btn { padding:8px 16px; border-radius:8px; border:none; cursor:pointer; font-size:13px; font-weight:500; display:inline-flex; align-items:center; gap:6px; text-decoration:none; transition:all .2s; }
        .btn-primary { background:#111; color:#fff; }
        .btn-primary:hover { background:#333; }
        .btn-gold { background:#e8c97e; color:#111; }
        .btn-gold:hover { background:#d4b86a; }
        .btn-danger { background:#ef4444; color:#fff; }
        .btn-danger:hover { background:#dc2626; }
        .btn-outline { background:#fff; border:1px solid #ddd; color:#111; }
        .btn-outline:hover { background:#f9fafb; }
        .btn-sm { padding:5px 10px; font-size:12px; border-radius:6px; }

        /* Badge */
        .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-green  { background:#d1fae5; color:#065f46; }
        .badge-blue   { background:#dbeafe; color:#1e40af; }
        .badge-yellow { background:#fef3c7; color:#92400e; }
        .badge-red    { background:#fee2e2; color:#991b1b; }
        .badge-purple { background:#ede9fe; color:#5b21b6; }
        .badge-gray   { background:#f3f4f6; color:#374151; }

        /* Form */
        .form-group { margin-bottom:16px; }
        .form-group label { display:block; font-size:13px; font-weight:500; margin-bottom:6px; color:#374151; }
        .form-control {
            width:100%; padding:9px 12px; border:1px solid #ddd;
            border-radius:8px; font-size:14px; font-family:inherit; outline:none;
        }
        .form-control:focus { border-color:#e8c97e; box-shadow:0 0 0 3px rgba(232,201,126,.15); }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .form-full { grid-column:1/-1; }

        /* Flash */
        .flash { padding:12px 20px; border-radius:8px; font-size:14px; margin-bottom:16px; }
        .flash-success { background:#d1fae5; color:#065f46; }
        .flash-error   { background:#fee2e2; color:#991b1b; }

        /* Thumbnail */
        .book-thumb { width:40px; height:52px; object-fit:cover; border-radius:4px; }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">📚 <span>Admin</span> Panel</div>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.books.index') }}" class="nav-item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Books
        </a>
        <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> Orders
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="{{ route('books.index') }}" class="nav-item">
            <i class="fas fa-store"></i> View Store
        </a>
    </nav>
    <div class="sidebar-footer">
        <p style="color:#666;font-size:12px;margin-bottom:8px;">{{ auth()->user()->name }}</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;color:#666;cursor:pointer;font-size:13px;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</aside>

<main class="main">
    @if(session('success'))
        <div class="flash flash-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">❌ {{ session('error') }}</div>
    @endif

    @yield('content')
</main>

@stack('scripts')
</body>
</html>