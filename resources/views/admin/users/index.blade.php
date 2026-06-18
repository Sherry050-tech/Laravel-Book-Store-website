@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>Manage Users</h1>
</div>

<div class="panel">
    <div class="panel-body" style="padding: 0;">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="background: #f1f1f1; border-bottom: 2px solid #ccc;">
                    <th style="padding: 12px 20px;">ID</th>
                    <th style="padding: 12px 20px;">User Details</th>
                    <th style="padding: 12px 20px;">Role</th>
                    <th style="padding: 12px 20px;">Joined</th>
                    <th style="padding: 12px 20px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px 20px; color: #666;">#{{ $user->id }}</td>
                    <td style="padding: 12px 20px;">
                        <strong>{{ $user->name }}</strong><br>
                        <span style="color: #666; font-size: 13px;">{{ $user->email }}</span>
                    </td>
                    <td style="padding: 12px 20px;">
                        @if($user->role === 'admin')
                            <span class="badge badge-purple">Admin</span>
                        @else
                            <span class="badge badge-gray">Customer</span>
                        @endif
                    </td>
                    <td style="padding: 12px 20px; color: #666; font-size: 13px;">{{ $user->created_at->format('M d, Y') }}</td>
                    <td style="padding: 12px 20px; display: flex; gap: 8px;">
                        
                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                            @csrf 
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline">
                                Make {{ $user->role === 'admin' ? 'Customer' : 'Admin' }}
                            </button>
                        </form>

                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this user?');">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #888;">
                        No users registered yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection