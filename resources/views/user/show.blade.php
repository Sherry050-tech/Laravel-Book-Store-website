@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 40px auto; padding: 0 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 800; margin: 0;">My Profile</h1>
        <a href="{{ route('user.dashboard') }}" style="color: #666; text-decoration: none; font-weight: 600;">
            &larr; Back to Dashboard
        </a>
    </div>

    <div style="background: #fff; padding: 40px; border-radius: 12px; border: 1px solid #eaeaea; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
        
        <div style="display: flex; align-items: center; gap: 24px; margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 30px;">
            <div style="width: 80px; height: 80px; background: #111; color: #e8c97e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 800;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size: 24px; font-weight: 800; margin: 0; color: #111;">{{ auth()->user()->name }}</h2>
                <p style="color: #666; margin: 4px 0 0 0; font-size: 14px;">
                    Member since {{ auth()->user()->created_at->format('F Y') }}
                </p>
            </div>
        </div>

        <div style="display: grid; gap: 24px; grid-template-columns: 1fr 1fr;">
            <div>
                <label style="display: block; font-size: 12px; font-weight: 800; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Email Address</label>
                <div style="background: #f9f9f9; padding: 16px; border-radius: 8px; border: 1px solid #eee; color: #111; font-weight: 600;">
                    {{ auth()->user()->email }}
                </div>
            </div>
            
            <div>
                <label style="display: block; font-size: 12px; font-weight: 800; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Account Type</label>
                <div style="background: #f9f9f9; padding: 16px; border-radius: 8px; border: 1px solid #eee; color: #111; font-weight: 600;">
                    {{ ucfirst(auth()->user()->role ?? 'Customer') }}
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection