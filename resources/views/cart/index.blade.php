@extends('layouts.app')

@push('styles')
<style>
    .cart-wrap { max-width:1000px; margin:40px auto; padding:0 24px; display:grid; grid-template-columns:1fr 320px; gap:28px; }
    .cart-title { font-size:26px; font-weight:700; margin-bottom:20px; }
    .cart-item {
        background:#fff; border-radius:12px; padding:16px;
        display:flex; gap:16px; align-items:center;
        box-shadow:0 1px 4px rgba(0,0,0,.08); margin-bottom:12px;
    }
    .cart-item-img { width:60px; height:80px; object-fit:cover; border-radius:6px; }
    .cart-item-info { flex:1; }
    .cart-item-title { font-weight:600; margin-bottom:4px; }
    .cart-item-author { font-size:13px; color:#888; margin-bottom:8px; }
    .cart-item-price { font-size:16px; font-weight:700; }
    .qty-controls { display:flex; align-items:center; gap:8px; margin-top:8px; }
    .qty-btn { width:28px; height:28px; border:1px solid #ddd; background:#fff; border-radius:6px; cursor:pointer; font-size:16px; }
    .qty-input { width:50px; text-align:center; border:1px solid #ddd; border-radius:6px; padding:4px; font-size:14px; }
    .remove-btn { color:#ef4444; background:none; border:none; cursor:pointer; font-size:13px; margin-top:6px; }

    .summary-card { background:#fff; border-radius:12px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,.08); height:fit-content; position:sticky; top:80px; }
    .summary-title { font-size:18px; font-weight:700; margin-bottom:20px; }
    .summary-row { display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px; }
    .summary-total { display:flex; justify-content:space-between; font-size:18px; font-weight:700; margin-top:16px; padding-top:16px; border-top:2px solid #111; }
    .btn-checkout { width:100%; padding:14px; background:#111; color:#fff; border:none; border-radius:10px; font-size:16px; font-weight:600; cursor:pointer; margin-top:16px; }
    .btn-checkout:hover { background:#333; }
    .shipping-note { font-size:12px; color:#888; text-align:center; margin-top:8px; }

    .empty-cart { text-align:center; padding:80px 20px; color:#aaa; }
    .empty-cart i { font-size:60px; margin-bottom:16px; display:block; }

    /* Checkout Modal */
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:999; align-items:center; justify-content:center; }
    .modal-overlay.open { display:flex; }
    .modal { background:#fff; border-radius:16px; padding:28px; max-width:480px; width:100%; max-height:90vh; overflow-y:auto; }
    .modal h3 { font-size:20px; font-weight:700; margin-bottom:20px; }
    .modal input, .modal select, .modal textarea {
        width:100%; padding:10px 14px; border:1px solid #ddd;
        border-radius:8px; font-size:14px; margin-bottom:12px;
        font-family:inherit; outline:none;
    }
    .modal input:focus { border-color:#e8c97e; }
    .modal-btns { display:flex; gap:12px; margin-top:8px; }
    .btn-cancel { flex:1; padding:12px; border:1px solid #ddd; background:#fff; border-radius:8px; cursor:pointer; }
    .btn-place { flex:2; padding:12px; background:#111; color:#fff; border:none; border-radius:8px; font-size:15px; font-weight:600; cursor:pointer; }
</style>
@endpush

@section('content')

<div style="padding:24px 40px 0; max-width:1100px; margin:0 auto;">
    <h1 class="cart-title">🛒 My Cart</h1>
</div>

@if($cartItems->count())
<div class="cart-wrap">
    <div>
        @foreach($cartItems as $item)
        <div class="cart-item" id="cart-row-{{ $item->id }}">
            <img src="{{ asset('storage/' . $item->book->image) }}"
                 onerror="this.src='https://via.placeholder.com/60x80?text=Book'"
                 class="cart-item-img" alt="{{ $item->book->title }}">
            <div class="cart-item-info">
                <p class="cart-item-title">{{ $item->book->title }}</p>
                <p class="cart-item-author">{{ $item->book->author }}</p>
                <p class="cart-item-price" id="line-{{ $item->id }}">${{ number_format($item->book->price * $item->quantity, 2) }}</p>
                <div class="qty-controls">
                    <button class="qty-btn" onclick="changeQty({{ $item->id }}, -1)">−</button>
                    <input type="number" class="qty-input" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="99" onchange="updateQty({{ $item->id }})">
                    <button class="qty-btn" onclick="changeQty({{ $item->id }}, 1)">+</button>
                </div>
                <form method="POST" action="{{ route('cart.remove', $item) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="remove-btn"><i class="fas fa-trash"></i> Remove</button>
                </form>
            </div>
        </div>
        @endforeach

        <form method="POST" action="{{ route('cart.clear') }}" style="margin-top:8px">
            @csrf @method('DELETE')
            <button type="submit" style="background:none;border:none;color:#ef4444;cursor:pointer;font-size:13px;">
                <i class="fas fa-trash"></i> Clear Cart
            </button>
        </form>
    </div>

    <!-- Summary -->
    <div>
        <div class="summary-card">
            <p class="summary-title">Order Summary</p>
            <div class="summary-row"><span>Subtotal</span><span id="subtotal">${{ number_format($subtotal, 2) }}</span></div>
            <div class="summary-row"><span>Shipping</span><span id="shipping">{{ $shipping == 0 ? 'FREE' : '$'.number_format($shipping,2) }}</span></div>
            <div class="summary-total"><span>Total</span><span id="total">${{ number_format($total, 2) }}</span></div>
            <button class="btn-checkout" onclick="document.getElementById('checkout-modal').classList.add('open')">
                Proceed to Checkout
            </button>
            <p class="shipping-note">
                @if($subtotal >= 49)
                    🎉 You get FREE shipping!
                @else
                    Spend ${{ number_format(49 - $subtotal, 2) }} more for FREE shipping
                @endif
            </p>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div class="modal-overlay" id="checkout-modal">
    <div class="modal">
        <h3>Complete Your Order</h3>
        <form method="POST" action="{{ route('orders.checkout') }}">
            @csrf
            <input type="text" name="customer_name" value="{{ auth()->user()->name }}" placeholder="Full Name *" required>
            <input type="email" name="customer_email" value="{{ auth()->user()->email }}" placeholder="Email *" required>
            <input type="tel" name="customer_phone" value="{{ auth()->user()->phone }}" placeholder="Phone Number">
            <textarea name="address" placeholder="Delivery Address *" rows="3" required>{{ auth()->user()->address }}</textarea>
            <select name="payment_method">
                <option value="cod">Cash on Delivery</option>
                <option value="card">Credit/Debit Card</option>
            </select>
            <div class="modal-btns">
                <button type="button" class="btn-cancel" onclick="document.getElementById('checkout-modal').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn-place">Place Order 🛒</button>
            </div>
        </form>
    </div>
</div>

@else
<div class="empty-cart">
    <i class="fas fa-shopping-cart"></i>
    <h3>Your cart is empty!</h3>
    <p style="margin-bottom:20px;">Browse our books and add something you love.</p>
    <a href="{{ route('books.index') }}" style="background:#111;color:#fff;padding:12px 28px;border-radius:10px;text-decoration:none;font-weight:600;">Browse Books</a>
</div>
@endif

@endsection

@push('scripts')
<script>
const token = document.querySelector('meta[name="csrf-token"]').content;

function changeQty(id, delta) {
    const input = document.getElementById('qty-' + id);
    const newVal = Math.max(1, parseInt(input.value) + delta);
    input.value = newVal;
    updateQty(id);
}

function updateQty(id) {
    const qty = document.getElementById('qty-' + id).value;
    fetch(`/cart/update/${id}`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify({ quantity: qty })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('line-' + id).textContent = '$' + data.lineTotal;
            document.getElementById('subtotal').textContent = '$' + data.subtotal;
            document.getElementById('shipping').textContent = data.shipping == '0.00' ? 'FREE' : '$' + data.shipping;
            document.getElementById('total').textContent = '$' + data.total;
        }
    });
}
</script>
@endpush