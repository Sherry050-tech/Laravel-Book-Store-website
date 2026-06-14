@extends('layouts.admin')

@section('content')
<div class="topbar">
    <h1>All Orders</h1>
    <form method="GET" style="display:flex;gap:8px;">
        <select name="status" class="form-control" style="width:160px;" onchange="this.form.submit()">
            <option value="">All Status</option>
            @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
            <option value="{{ $s }}" {{ request('status')==$s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="panel">
    <table>
        <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($orders as $order)
        <tr>
            <td><strong>#{{ $order->id }}</strong></td>
            <td>{{ $order->customer_name }}<br><small style="color:#9ca3af">{{ $order->customer_email }}</small></td>
            <td><strong>${{ number_format($order->total,2) }}</strong></td>
            <td><span class="badge badge-gray">{{ strtoupper($order->payment_method) }}</span></td>
            <td>
                <select class="form-control" style="width:130px;padding:4px 8px;font-size:12px;" onchange="updateStatus({{ $order->id }}, this.value)">
                    @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status==$s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </td>
            <td style="font-size:13px;color:#9ca3af">{{ $order->created_at->format('M d, Y') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" style="display:inline" onsubmit="return confirm('Delete this order?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:40px;color:#aaa;">No orders found</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $orders->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
function updateStatus(id, status) {
    fetch(`/admin/orders/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const flash = document.createElement('div');
            flash.className = 'flash flash-success';
            flash.textContent = '✅ Order #' + id + ' status updated to ' + status;
            document.querySelector('.main').prepend(flash);
            setTimeout(() => flash.remove(), 3000);
        }
    });
}
</script>
@endpush