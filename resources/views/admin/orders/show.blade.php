@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>Order #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;">
    <div>
        <div class="panel" style="margin-bottom:16px;">
            <div class="panel-header"><h2>Items Ordered</h2></div>
            <table>
                <thead><tr><th>Book</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td><strong>{{ $item->title }}</strong><br><small style="color:#9ca3af">{{ $item->author }}</small></td>
                    <td>${{ number_format($item->price,2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td><strong>${{ number_format($item->price * $item->quantity,2) }}</strong></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="panel">
            <div class="panel-header"><h2>Customer Info</h2></div>
            <div class="panel-body" style="font-size:14px;">
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p style="margin-top:8px;"><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p style="margin-top:8px;"><strong>Phone:</strong> {{ $order->customer_phone ?: 'N/A' }}</p>
                <p style="margin-top:8px;"><strong>Address:</strong> {{ $order->address ?: 'N/A' }}</p>
                <p style="margin-top:8px;"><strong>Payment:</strong> {{ strtoupper($order->payment_method) }}</p>
            </div>
        </div>
    </div>

    <div>
        <div class="panel">
            <div class="panel-header"><h2>Order Summary</h2></div>
            <div class="panel-body">
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:14px;"><span>Subtotal</span><span>${{ number_format($order->subtotal,2) }}</span></div>
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:14px;"><span>Shipping</span><span>{{ $order->shipping == 0 ? 'FREE' : '$'.number_format($order->shipping,2) }}</span></div>
                <div style="display:flex;justify-content:space-between;font-size:18px;font-weight:700;padding-top:12px;border-top:2px solid #111;"><span>Total</span><span>${{ number_format($order->total,2) }}</span></div>

                <div style="margin-top:20px;">
                    <label style="font-size:13px;font-weight:500;display:block;margin-bottom:6px;">Update Status</label>
                    <select id="status-select" class="form-control" style="margin-bottom:10px;">
                        @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->status==$s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button onclick="updateStatus()" class="btn btn-gold" style="width:100%;">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateStatus() {
    const status = document.getElementById('status-select').value;
    fetch(`/admin/orders/{{ $order->id }}/status`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ status })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) alert('Status updated to: ' + status);
    });
}
</script>
@endpush