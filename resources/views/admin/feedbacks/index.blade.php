@extends('layouts.admin')

@section('content')
<div class="topbar" style="margin-bottom: 20px;">
    <h1>Customer Feedback</h1>
</div>

<div class="panel">
    <div class="panel-body">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="background: #f1f1f1; border-bottom: 2px solid #ccc;">
                    <th style="padding: 12px;">Customer</th>
                    <th style="padding: 12px;">Rating</th>
                    <th style="padding: 12px;">Comment</th>
                    <th style="padding: 12px;">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedbacks as $feedback)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">
                        <strong>{{ $feedback->user->name ?? 'Unknown User' }}</strong><br>
                        <span style="color: #666; font-size: 13px;">{{ $feedback->user->email ?? '' }}</span>
                    </td>
                    <td style="padding: 12px; font-size: 18px;">
                        {{ str_repeat('⭐', $feedback->rating) }}
                    </td>
                    <td style="padding: 12px; font-style: italic;">
                        "{{ $feedback->comment }}"
                    </td>
                    <td style="padding: 12px; color: #888; font-size: 13px;">
                        {{ $feedback->created_at->format('M d, Y h:i A') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 20px; text-align: center; color: #888;">
                        No feedback submitted yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection