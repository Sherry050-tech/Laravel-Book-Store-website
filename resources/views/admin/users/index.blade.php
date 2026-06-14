@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>All Users</h1>
</div>

<div class="panel">
    <table>
        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Orders</th><th>Joined</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($users as $user)
        <tr>
            <td><strong>{{ $user->name }}</strong></td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone ?: '—' }}</td>
            <td><span class="badge badge-blue">{{ $user->orders_count ?? $user->orders()->count() }}</span></td>
            <td style="font-size:13px;color:#9ca3af">{{ $user->created_at->format('M d, Y') }}</td>
            <td>
                <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                    {{ $user->is_active ? 'Active' : 'Blocked' }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
                <form method="POST" action="{{ route('admin.users.toggle', $user) }}" style="display:inline">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-gold' }}">
                        {{ $user->is_active ? 'Block' : 'Unblock' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline" onsubmit="return confirm('Delete this user?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:40px;color:#aaa;">No users found</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $users->links() }}</div>
</div>
@endsection