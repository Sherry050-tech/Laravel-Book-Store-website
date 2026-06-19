@extends('layouts.app')

@push('styles')
<style>
    .wrap { max-width:600px; margin:40px auto; padding:0 24px; }
    .profile-card { background:#fff; border-radius:16px; padding:32px; box-shadow:0 2px 8px rgba(0,0,0,.08); }
    .profile-header { text-align:center; margin-bottom:28px; }
    .avatar { width:80px; height:80px; background:#111; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:32px; color:#e8c97e; margin:0 auto 12px; }
    .profile-header h2 { font-size:22px; font-weight:700; }
    .profile-header p { color:#888; font-size:14px; }
    .form-group { margin-bottom:16px; }
    .form-group label { display:block; font-size:13px; font-weight:500; margin-bottom:6px; color:#374151; }
    .form-group input, .form-group textarea {
        width:100%; padding:10px 14px; border:1px solid #ddd;
        border-radius:8px; font-size:14px; outline:none;
    }
    .form-group input:focus { border-color:#e8c97e; }
    .btn-save { width:100%; padding:13px; background:#111; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600; cursor:pointer; }
    .btn-save:hover { background:#333; }
</style>
@endpush

@section('content')
<div class="wrap">
    <div class="profile-card">
        <div class="profile-header">
            <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }}</p>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Your phone number">
            </div>
            <div class="form-group">
                <label>Delivery Address</label>
                <textarea name="address" rows="3" placeholder="Your default delivery address">{{ old('address', $user->address) }}</textarea>
            </div>
            <button type="submit" class="btn-save">Save Changes</button>
        </form>
    </div>
</div>
@endsection